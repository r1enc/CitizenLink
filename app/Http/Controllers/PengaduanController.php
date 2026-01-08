<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class PengaduanController extends Controller
{
    // Simpan laporan dengan validasi duplikat sederhana
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'isi_laporan' => 'required|min:10',
            'lokasi' => 'required',
            'foto_bukti' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 2. Ambil 3 kata pertama sebagai keyword
        $keyword = Str::words($request->isi_laporan, 3, '');

        // 3. Cek potensi duplikat (Keyword & Lokasi)
        $duplikat = Laporan::where('status_laporan', '!=', 'selesai')
            ->where('isi_laporan', 'like', '%' . $keyword . '%')
            ->where('lokasi', 'like', '%' . $request->lokasi . '%')
            ->first();

        // 4. Jika duplikat, alihkan ke konfirmasi
        if ($duplikat) {
            return view('warga.duplikat_konfirmasi', [
                'laporan_existing' => $duplikat,
                'data_baru' => $request->all()
            ]);
        }

        // 5. Simpan laporan baru
        $path = $request->file('foto_bukti')->store('bukti_laporan', 'public');

        Laporan::create([
            'nik_pelapor' => Auth::user()->nik,
            'isi_laporan' => $request->isi_laporan,
            'lokasi' => $request->lokasi,
            'foto_bukti' => $path,
            'status_laporan' => '0', 
            'jumlah_upvote' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan kamu berhasil terkirim!');
    }

    // Penyelesaian laporan oleh petugas
    public function selesaikanLaporan(Request $request, $id)
    {
        // 1. Validasi bukti penanganan
        $request->validate([
            'foto_penanganan' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // 2. Verifikasi kepemilikan tugas
        $laporan = Laporan::where('id_laporan', $id)
                          ->where('petugas_id', Auth::id()) 
                          ->firstOrFail();

        // 3. Upload dan update data
        if ($request->hasFile('foto_penanganan')) {
            $path = $request->file('foto_penanganan')->store('bukti_penanganan', 'public');
            $laporan->foto_penanganan = $path;
        }

        $laporan->status_laporan = 'selesai';
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan berhasil diselesaikan & bukti terupload!');
    }
    
    // Fitur Upvote
    public function upvote($id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);
        $laporan->increment('jumlah_upvote'); 
        
        return redirect()->route('dashboard')->with('success', 'Terima kasih! Dukungan kamu berhasil ditambahkan.');
    }
}