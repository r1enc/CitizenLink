<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use App\Models\User;
use App\Models\Komentar; 
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KomunitasController extends Controller
{
    public function index(Request $request)
    {
        // 1. Load diskusi & hitung komentar
        $query = Diskusi::with(['user'])->withCount('komentars as komentars_count'); 

        if ($request->has('kategori') && $request->kategori != 'Semua') {
            $query->where('kategori', $request->kategori);
        }
        $diskusis = $query->latest()->get();

        // 2. Top 5 Pelapor Teraktif
        $topPelaporData = Laporan::select('nik_pelapor', DB::raw('count(*) as total'))
            ->groupBy('nik_pelapor')->orderByDesc('total')->take(5)->get();
        
        $niks = $topPelaporData->pluck('nik_pelapor');
        $usersPelapor = User::whereIn('nik', $niks)->get()->keyBy('nik');
        
        $topPelapor = $topPelaporData->map(function($item) use ($usersPelapor) {
            $item->user = $usersPelapor[$item->nik_pelapor] ?? null;
            return $item;
        })->filter(function($item) { return $item->user != null; });

        // 3. Top 5 Petugas Terbaik
        $topPetugasData = Laporan::where('status_laporan', 'selesai')
            ->whereNotNull('petugas_id')
            ->select('petugas_id', DB::raw('count(*) as total'))
            ->groupBy('petugas_id')->orderByDesc('total')->take(5)->get();

        $ids = $topPetugasData->pluck('petugas_id');
        $usersPetugas = User::whereIn('id', $ids)->get()->keyBy('id');

        $topPetugas = $topPetugasData->map(function($item) use ($usersPetugas) {
            $item->user = $usersPetugas[$item->petugas_id] ?? null;
            return $item;
        })->filter(function($item) { return $item->user != null; });

        return view('komunitas', compact('diskusis', 'topPelapor', 'topPetugas'));
    }

    public function create() { return view('komunitas.diskusi'); }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = [
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('diskusi-photos', 'public');
        }

        Diskusi::create($data);
        return redirect()->route('komunitas')->with('success', 'Diskusi berhasil diposting!');
    }

    public function show($id)
    {
        $diskusi = Diskusi::with(['user', 'komentars.user'])->findOrFail($id);
        return view('komunitas.reply', compact('diskusi'));
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|max:500',
            'foto' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:komentars,id' // Support Nested Reply
        ]);

        $data = [
            'user_id' => Auth::id(),
            'diskusi_id' => $id,
            'isi_komentar' => $request->isi_komentar,
            'parent_id' => $request->parent_id 
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('komentar-photos', 'public');
        }

        Komentar::create($data);
        return back()->with('success', 'Komentar terkirim!');
    }
}