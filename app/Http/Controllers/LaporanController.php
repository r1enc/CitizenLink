<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\SlaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    // --- FUNGSI 1: SIMPAN LAPORAN (CORE LOGIC) ---
    public function store(Request $request)
    {
        $request->validate([
            'isi_laporan' => 'required',
            'lokasi'      => 'nullable',
            'alamat_manual' => 'nullable|string|max:500',
            'foto_bukti'  => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Prioritas lokasi manual
        $lokasiFinal = $request->alamat_manual ?: $request->lokasi;
        if (empty($lokasiFinal)) return back()->withErrors(['lokasi' => 'Wajib isi lokasi!']);

        $path = $request->hasFile('foto_bukti') ? $request->file('foto_bukti')->store('bukti_laporan', 'public') : null;

        $teks = strtolower($request->isi_laporan);
        $kategori = 'Lainnya'; 
        $prioritas = 'Rendah'; 
        $parentId = null;

        // A. Logic Duplikat (Gabung Laporan)
        if ($request->duplicate_id) {
            $parent = Laporan::find($request->duplicate_id);
            if ($parent) {
                // Recursive check: Pastikan parent adalah induk asli
                if ($parent->duplicate_of_id != null) {
                    $realParent = Laporan::find($parent->duplicate_of_id);
                    if ($realParent) $parent = $realParent;
                }
                
                $parentId = $parent->id_laporan;
                $kategori = $parent->kategori;
                $parent->increment('jumlah_upvote');

                // Auto-Eskalasi Prioritas per 5 upvote
                if ($parent->jumlah_upvote % 5 == 0) {
                    $levels = ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'];
                    $currentKey = array_search($parent->prioritas, $levels);
                    if ($currentKey !== false && $currentKey < 3) {
                        $parent->prioritas = $levels[$currentKey + 1];
                    }
                }
                $parent->save();
                $prioritas = $parent->prioritas; 
            }
        } 
        // B. Logic Laporan Baru (SLA Rule)
        else {
            // Tentukan prioritas berdasarkan keyword DB
            $rule = SlaRule::whereRaw("? LIKE CONCAT('%', keyword, '%')", [$teks])
                            ->orderByRaw("FIELD(prioritas, 'Sangat Tinggi', 'Tinggi', 'Sedang', 'Rendah')")
                            ->first();
            if ($rule) {
                $kategori = $rule->kategori;
                $prioritas = $rule->prioritas;
            }
        }

        // Insert Database
        $laporan = Laporan::create([
            'nik_pelapor'    => Auth::user()->nik ?? Auth::id(), 
            'isi_laporan'    => $request->isi_laporan,
            'lokasi'         => $lokasiFinal, 
            'alamat_manual'  => $request->alamat_manual,
            'latitude'       => $request->latitude, 
            'longitude'      => $request->longitude,
            'foto_bukti'     => $path,
            'kategori'       => $kategori,
            'status_laporan' => '0', 
            'prioritas'      => $prioritas,
            'jumlah_upvote'  => 0, 
            'duplicate_of_id' => $parentId 
        ]);

        return redirect()->route('pengaduan.sukses', $laporan->id_laporan);
    }

    // --- FUNGSI 2: CEK DUPLIKAT (AI LOGIC) ---
    public function cekDuplikat(Request $request)
    {
        $inputIsi = strtolower(trim($request->isi));
        $inputLokasi = strtolower(trim($request->lokasi));
        
        if (strlen($inputIsi) < 3) return response()->json(['status' => 'clean']);

        // 1. Siapkan keyword (DB + Hardcode)
        $dbKeywords = SlaRule::pluck('keyword')->map(fn($k) => strtolower($k))->toArray();
        $backupKeywords = ['banjir', 'kebakaran', 'macet', 'rusak', 'lubang', 'sampah', 'maling', 'mati', 'gelap'];
        $masterKeywords = array_unique(array_merge($dbKeywords, $backupKeywords));

        // 2. Deteksi masalah dalam input
        $detectedProblems = [];
        foreach ($masterKeywords as $kw) {
            if (str_contains($inputIsi, $kw)) $detectedProblems[] = $kw;
        }
        $isGenericSearch = empty($detectedProblems);

        // 3. Ambil 50 kandidat laporan aktif
        $candidates = Laporan::where('status_laporan', '!=', 'ditolak')
                             ->whereNull('duplicate_of_id') 
                             ->latest()->take(50)->get();
        
        $addrStopwords = ['jalan', 'jl', 'jl.', 'gang', 'gg', 'blok', 'no', 'nomor', 'rt', 'rw', 'kel', 'kec', 'kab', 'kota'];

        foreach ($candidates as $laporan) {
            // A. Cek Kemiripan Lokasi (Token Match)
            $dbLokasi = strtolower($laporan->lokasi);
            $rawInput = explode(' ', preg_replace('/[^a-z0-9 ]/', ' ', $inputLokasi));
            $rawDb    = explode(' ', preg_replace('/[^a-z0-9 ]/', ' ', $dbLokasi));
            
            // Filter stopword
            $tokensInput = array_filter($rawInput, fn($w) => !in_array($w, $addrStopwords) && strlen($w) > 2);
            $matches = array_intersect($tokensInput, $rawDb);
            
            $inputCount = count($tokensInput);
            $matchCount = count($matches);
            $ratio = ($inputCount > 0) ? ($matchCount / $inputCount) : 0;
            
            // Jika lokasi > 60% mirip, lanjut cek isi
            if ($ratio >= 0.6) {
                $dbIsi = strtolower($laporan->isi_laporan);
                $found = false;

                // B. Match keyword masalah
                foreach ($detectedProblems as $problem) {
                    if (str_contains($dbIsi, $problem)) {
                        $found = true; break; 
                    }
                }
                // C. Substring match (Input pendek ada di dalam DB)
                if (!$found && strlen($inputIsi) < 20 && str_contains($dbIsi, $inputIsi)) {
                    $found = true;
                }
                // D. Similar Text (Jika keyword tidak spesifik)
                if (!$found && $isGenericSearch) {
                    $sim = 0; similar_text($inputIsi, $dbIsi, $sim);
                    if ($sim > 80) $found = true;
                }

                if ($found) {
                    // Ambil 4 kata pertama dari isi laporan yang ditemukan buat jadi keyword search
                    $keywordPencarian = Str::words($laporan->isi_laporan, 4, '');

                    return response()->json([
                        'status' => 'found', 
                        'data' => $laporan, 
                        // Arahkan ke jelajah dengan parameter ?search=keyword
                        'url_tracking' => route('feed', ['search' => $keywordPencarian])
                    ]);
                }
            }
        }
        return response()->json(['status' => 'clean']);
    }

    // --- FUNGSI 3: UPDATE STATUS (ADMIN) ---
    public function updateStatus(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        // Fitur Pisahkan Duplikat
        if ($request->has('pisahkan_duplikat')) {
            if ($laporan->duplicate_of_id) {
                // Decrement vote induk
                $induk = Laporan::find($laporan->duplicate_of_id);
                if($induk && $induk->jumlah_upvote > 0) {
                    $induk->decrement('jumlah_upvote');
                }
            }
            $laporan->duplicate_of_id = null;
            $laporan->status_laporan = '0';
            $laporan->save();
            return redirect()->back()->with('success', 'Laporan dipisahkan.');
        }

        if ($request->has('status')) $laporan->status_laporan = $request->status;

        // Set Kategori & Prioritas Otomatis
        if ($request->has('kategori')) {
            $laporan->kategori = $request->kategori; 
            $laporan->is_manual_category = 1;
            switch($request->kategori) {
                case 'Bencana & Darurat': $laporan->prioritas = 'Sangat Tinggi'; break;
                case 'Infrastruktur Kritis': case 'Utilitas Umum': $laporan->prioritas = 'Tinggi'; break;
                case 'Kesehatan & Lingkungan': case 'Ketertiban & Keamanan': $laporan->prioritas = 'Sedang'; break;
                case 'Pelayanan Publik': $laporan->prioritas = 'Rendah'; break;
            }
        }
        
        if ($request->has('prioritas')) { 
            $laporan->prioritas = $request->prioritas; 
            $laporan->is_manual_priority = 1; 
        }

        $laporan->save();
        return redirect()->back();
    }

    // --- FUNGSI 4: POOL TUGAS PETUGAS ---
    public function indexPetugas()
    {
        // Filter: Belum diambil, Valid, & Siap proses
        $laporans = Laporan::whereNull('petugas_id')
                           ->where('status_laporan', '!=', '0')
                           ->whereNotIn('status_laporan', ['ditolak', 'selesai'])
                           ->latest()
                           ->get();

        return view('dashboard_parts._petugas', compact('laporans'));
    }

    // --- FUNGSI 5: TUGAS SAYA ---
    public function tugasSaya()
    {
        $mytasks = Laporan::where('petugas_id', Auth::id())
                          ->orderBy('updated_at', 'desc')
                          ->get();

        return view('petugas.tugas_saya', compact('mytasks'));
    }

    // --- FUNGSI 6: AMBIL LAPORAN ---
    public function ambilLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        // Cek Race Condition
        if ($laporan->petugas_id != null) return redirect()->back()->with('error', 'Sudah diambil orang lain.');
        
        $laporan->petugas_id = Auth::id(); 
        $laporan->status_laporan = 'proses'; 
        $laporan->save();
        
        return redirect()->route('tugas.saya')->with('success', 'Laporan diambil! Silakan kerjakan.');
    }

    // --- FUNGSI 7: LEPAS LAPORAN ---
    public function lepasLaporan($id)
    {
        $laporan = Laporan::where('id_laporan', $id)->where('petugas_id', Auth::id())->firstOrFail();
        $laporan->petugas_id = null; 
        $laporan->status_laporan = '0'; 
        $laporan->save();
        
        return redirect()->back()->with('success', 'Dikembalikan ke antrian.');
    }

    // --- FUNGSI 8: SELESAI ---
    public function selesaikanLaporan(Request $request, $id)
    {
        $request->validate([
            'foto_penanganan' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $laporan = Laporan::where('id_laporan', $id)->where('petugas_id', Auth::id())->firstOrFail();

        if ($request->hasFile('foto_penanganan')) {
            $path = $request->file('foto_penanganan')->store('bukti_penanganan', 'public');
            $laporan->foto_penanganan = $path;
        }

        $laporan->status_laporan = 'selesai';
        $laporan->save();

        return redirect()->back()->with('success', 'Tugas Selesai! Kerja bagus.');
    }

    // --- FUNGSI LAIN ---
    public function upvote($id) { 
        $laporan = Laporan::findOrFail($id); $userId = Auth::id(); 
        $existing = DB::table('laporan_dukungans')->where('id_laporan', $id)->where('user_id', $userId)->first(); 
        if ($existing) { 
            // Unvote
            DB::table('laporan_dukungans')->where('id', $existing->id)->delete(); $laporan->decrement('jumlah_upvote'); 
        } else { 
            // Vote
            DB::table('laporan_dukungans')->insert(['id_laporan' => $id, 'user_id' => $userId, 'created_at' => now(), 'updated_at' => now()]); $laporan->increment('jumlah_upvote'); 
        } 
        $laporan->save(); return response()->json(['status' => 'success', 'new_count' => $laporan->jumlah_upvote]); 
    }

    public function showPublic($id) { return view('tracking', ['laporan' => Laporan::findOrFail($id), 'hasVoted' => false]); }
    public function cariLaporan(Request $request) { $laporan = Laporan::where('id_laporan', $request->keyword)->first(); return $laporan ? redirect()->route('laporan.tracking', $laporan->id_laporan) : redirect()->back(); }
    public function sukses($id) { return view('laporan.sukses', ['laporan' => Laporan::findOrFail($id)]); }
}