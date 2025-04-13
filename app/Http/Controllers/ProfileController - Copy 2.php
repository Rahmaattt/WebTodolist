<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function profile(Request $request) {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke public_html/uploads langsung
            $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/profile_photos';

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);

            $user = Auth::user();
            $user->profile_photo = 'uploads/profile_photos/' . $filename;
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui.');
        }

    return back()->with('error', 'Tidak ada file yang diupload.');
    }
}