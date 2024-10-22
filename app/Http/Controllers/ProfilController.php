<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // Menambahkan middleware auth untuk memastikan user sudah login
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Kirim data user ke view
        $activeMenu = 'profil';
        $breadcrumb = (object) [
            'title' => 'Edit Profil',
            'list' => ['Home', 'Edit Profil']
        ];
        $page = (object) [
            'title' => 'Upload foto'
        ];

        return view('profil.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'profil' => $user // Mengoper data user ke view
        ]);
    }

    public function update(Request $request)
    {
        // Pastikan user sudah login
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Validasi input avatar
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hapus avatar lama jika ada
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Upload avatar baru
        if ($request->file('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $avatarName);

            // Simpan avatar baru ke database
            $user->avatar = $avatarName;
            $user->save();
        }

        return redirect('/profil')->with('success', 'Foto Profil Berhasil Diperbarui!');
    }
}
