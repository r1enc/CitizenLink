<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Laporan; 
use App\Models\User; 

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // 1. View Admin
        if ($role == 'admin') {
            $query = Laporan::with('pelapor')->latest();

            // Filter Status
            if (request('status')) {
                $query->where('status_laporan', request('status'));
            } else {
                // Default: Antrian & Induk Saja
                $query->where('status_laporan', '0')
                      ->whereNull('duplicate_of_id');
            }
            $laporans = $query->get();

            // Hitung Statistik (Hanya Induk)
            $stats = [
                'total' => Laporan::whereNull('duplicate_of_id')->count(),
                'baru'  => Laporan::whereNull('duplicate_of_id')->where('status_laporan', '0')->count(),
                'proses'=> Laporan::whereNull('duplicate_of_id')->where('status_laporan', 'proses')->count(),
                'selesai'=> Laporan::whereNull('duplicate_of_id')->where('status_laporan', 'selesai')->count(),
                'tinggi'=> Laporan::whereNull('duplicate_of_id')->whereIn('prioritas', ['Tinggi', 'Sangat Tinggi'])->count(),
            ];

            return view('dashboard_parts._admin', compact('laporans', 'stats'));
        }
        
        // 2. View Petugas (Pool Tugas)
        if ($role == 'petugas') {
            $laporans = Laporan::whereNull('petugas_id')
                               ->whereNull('duplicate_of_id') 
                               ->whereIn('status_laporan', ['0', 'proses']) 
                               ->latest()->get();
            return view('dashboard_parts._petugas', compact('laporans'));
        }

        // 3. View Warga (Riwayat)
        $riwayat = Laporan::where('nik_pelapor', Auth::user()->nik)->latest()->get();
        return view('dashboard_parts._warga', compact('riwayat'));
    }

    // --- Helper Functions ---
    public function tugasSaya() { $mytasks = Laporan::where('petugas_id', Auth::id())->latest()->get(); return view('petugas.tugas_saya', compact('mytasks')); }
    public function kelolaPetugas() { $petugas = User::where('role', 'petugas')->latest()->get(); return view('admin.petugas', compact('petugas')); }
    
    // Create Petugas (Auto Username)
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|numeric|unique:users,nik',
            'password' => 'required|min:8',
        ]);

        // Generate: "Agus Santoso" -> "petugas_agus"
        $firstName = strtolower(explode(' ', $request->name)[0]); 
        $generatedUsername = 'petugas_' . $firstName;

        User::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'nik' => $request->nik,
            'username' => $generatedUsername, 
            'password' => Hash::make($request->password), 
            'role' => 'petugas', 
        ]);

        return redirect()->back()->with('success', 'Petugas berhasil ditambahkan! Username Login: ' . $generatedUsername);
    }

    public function destroyPetugas($id) { User::findOrFail($id)->delete(); return redirect()->back(); }
    public function timeline() { $laporans = Laporan::whereNull('duplicate_of_id')->with('pelapor')->latest()->get(); return view('admin.timeline', compact('laporans')); }
    
    public function laporanDuplikat() {
        $laporans = Laporan::whereNull('duplicate_of_id')->has('duplicates')->with(['pelapor', 'duplicates.pelapor'])->latest()->get();
        return view('admin.duplikat', compact('laporans'));
    }
}