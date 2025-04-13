<?php

/*namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    
    public function update(Request $request) {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Simpan file di storage (folder: storage/app/public/profile_photos)
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // Salin file ke folder public (misalnya, public/uploads) jika diperlukan
            $storagePath = storage_path('app/public/' . $path);
            $publicPath = public_path('uploads/' . $path);
            if (!file_exists(dirname($publicPath))) {
                mkdir(dirname($publicPath), 0777, true);
            }
            copy($storagePath, $publicPath);

            // Simpan path ke database (misalnya, hanya menyimpan path relatif)
            $user->profile_photo = $path;
        }

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
    
    public function profile(Request $request) {
      $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if ($request->hasFile('profile_photo')) {
        // Simpan file ke storage dengan disk 'public'
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Tentukan path file di storage
        $storagePath = storage_path('app/public/' . $path);
        
        // Tentukan path tujuan di public (misalnya, simpan di public/uploads)
        $publicPath = public_path('uploads/' . $path);
        
        // Pastikan direktori tujuan ada, jika tidak buat direktori tersebut
        if (!file_exists(dirname($publicPath))) {
            mkdir(dirname($publicPath), 0777, true);
        }
        
        // Salin file dari storage ke folder public
        if (!copy($storagePath, $publicPath)) {
            return back()->with('error', 'Gagal menyalin file ke folder public.');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Simpan path file (misal path relatif dari folder storage) ke kolom profile_photo di database
        $user->profile_photo = $path;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
      }

      return back()->with('error', 'Tidak ada file yang diupload.');
    }
}*/

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

    // Memproses update data profil (profile_photo dan nama)
    /*public function profile(Request $request)
    {
        try {
            Log::info('Memulai update profil');

            $request->validate([
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name' => 'nullable|string|max:255',
            ]);

            $user = Auth::user();

            // Cek dan simpan file foto
            if ($request->hasFile('profile_photo')) {
                Log::info('File ditemukan', ['file' => $request->file('profile_photo')->getClientOriginalName()]);

                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                Log::info('File disimpan di storage', ['path' => $path]);

                $storagePath = storage_path('app/public/' . $path);
                $publicPath = public_path('uploads/' . $path);

                if (!file_exists(dirname($publicPath))) {
                    mkdir(dirname($publicPath), 0777, true);
                    Log::info('Folder public uploads dibuat', ['path' => dirname($publicPath)]);
                }

                if (!copy($storagePath, $publicPath)) {
                    Log::error('Gagal menyalin file ke public', ['from' => $storagePath, 'to' => $publicPath]);
                    return back()->with('error', 'Gagal menyalin file ke folder public.');
                }

                $user->profile_photo = $path;
            }

            // Update nama jika dikirim
            if ($request->filled('name')) {
                Log::info('Nama akan diperbarui', ['name' => $request->input('name')]);
                $user->name = $request->input('name');
            }

            $user->save();
            Log::info('Profil berhasil disimpan ke database');

            return back()->with('success', 'Profil berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('Terjadi error saat update profil', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi error saat memperbarui profil.');
        }
    }*/

    /*public function profile(Request $request)
{
    try {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            // Buat nama unik
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan langsung di public/uploads/profile_photos
            $destinationPath = public_path('uploads/profile_photos');

            // Pastikan folder ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);

            // Simpan path relatif untuk ditampilkan
            $user = Auth::user();
            $user->profile_photo = 'uploads/profile_photos/' . $filename;
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('error', 'Tidak ada file yang diupload.');
    } catch (\Throwable $e) {
        \Log::error('Gagal update profile: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat upload.');
    }
}*/

/*public function profile(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Ganti path ini dengan path absolut root hosting kamu
        $destinationPath = '/home/username/public_html/uploads/profile_photos';

        // Cek apakah foldernya ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Pindahkan file ke direktori root hosting
        $file->move($destinationPath, $filename);

        // Simpan ke database, hanya relative path
        $user = Auth::user();
        $user->profile_photo = 'uploads/profile_photos/' . $filename;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    return back()->with('error', 'Tidak ada file yang diupload.');
}*/

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