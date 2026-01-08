<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 

class LandingController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // Feed Laporan
    public function feed(Request $request)
    {
        $query = Laporan::query();

        // Filter: Hanya tampilkan laporan induk
        $query->whereNull('duplicate_of_id');

        // Fitur Search
        if ($request->has('search')) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('isi_laporan', 'LIKE', "%{$keyword}%");
            });
        }

        // Sortir: Terpopuler & Terbaru
        $laporan = $query->orderBy('jumlah_upvote', 'desc')
                         ->latest()
                         ->paginate(9);

        return view('feed', compact('laporan'));
    }

    public function panduan() { return view('panduan'); }

    // Toggle Upvote (AJAX)
    public function toggleUpvote($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Login dulu!'], 401);
        }
        
        $userId = Auth::id(); 
        $existing = DB::table('laporan_dukungans')
            ->where('id_laporan', $id)
            ->where('user_id', $userId)
            ->first();

        $action = '';

        if ($existing) {
            // Unvote
            DB::table('laporan_dukungans')->where('id', $existing->id)->delete();
            $laporan->decrement('jumlah_upvote');
            $action = 'unvoted';
        } else {
            // Vote
            DB::table('laporan_dukungans')->insert([
                'id_laporan' => $id, 
                'user_id' => $userId, 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
            $laporan->increment('jumlah_upvote');
            $action = 'voted';
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'new_count' => $laporan->jumlah_upvote
        ]);
    }
}