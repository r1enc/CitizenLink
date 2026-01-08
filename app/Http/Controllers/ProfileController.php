<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Tampilkan form edit profil
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Update data profil user
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Isi model user dengan data yang sudah divalidasi
        $request->user()->fill($request->validated());

        // Jika email berubah, reset status verifikasi (wajib verifikasi ulang)
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Hapus akun user secara permanen
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password user saat ini (Konfirmasi keamanan)
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout(); // Logout user

        $user->delete(); // Hapus data dari database

        // Invalidate session & token (Mencegah serangan CSRF/Session Hijacking)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}