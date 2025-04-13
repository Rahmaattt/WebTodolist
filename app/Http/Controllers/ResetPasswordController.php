<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPassword;
use App\Models\User;

class ResetPasswordController extends Controller {
  
  public function lupaPw() {
    return view("sesi/lupapw");
  }
  
  public function updatePw($token) {
    $resetPassword = DB::table('password_reset_tokens')->where('token', $token)->first();
    
    if (!$resetPassword) {
      return redirect('sesi/lupapw')->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
    }
    
    session(['reset_token' => $token]);
    
    return view("sesi/updatepw", compact('token'));
  }
  
  public function lupaPwPost(Request $request) {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email'
    ], [
      'name.required' => 'Nama wajib diisi',
      'email.required' => 'Email wajib diisi',
      'email.email' => 'Format email tidak valid'
    ]);

    $name = $request->name;
    $email = $request->email;

    $user = User::where('name', $name)->where('email', $email)->first();
    
    if (!$user) {
      $name = User::where('name', $name)->first();
      $email = User::where('email', $email)->first();

      if ($name && !$email) {
        return back()->withErrors(['email' => 'Email tidak ditemukan']);
      } elseif (!$name && $email) {
        return back()->withErrors(['name' => 'Nama tidak ditemukan']);
      } else {
        return back()->withErrors(['name' => 'Nama tidak ditemukan', 'email' => 'Email tidak ditemukan']);
      }
    }
    
    $token = Str::random(60);
    DB::table('password_reset_tokens')->updateOrInsert(
      ['email' => $user->email],
      [
        'token'      => $token, 
        'created_at' => Carbon::now()
      ]
    );
    
    $resetLink = url('/sesi/updatepw', $token);
    
    $resetData = [
      'name'      => $user->name,
      'email'     => $user->email,
      'token'     => $token,
      'resetLink' => $resetLink,
      'subject'   => 'Reset Password'
    ];
        
    Mail::to($user->email)->send(new ResetPassword($resetData));
    
    return back()->with('status', 'Kami telah mengirim email reset password ke email Anda!');

  }
  
  public function updatePwPost(Request $request) {
    $request->validate([
      'password' => 'required|min:6|confirmed',
      'password_confirmation' => 'required',
    ], [
      'password.required' => 'Password wajib diisi',
      'password.min' => 'Password harus minimal 6 karakter',
      'password.confirmed' => 'Konfirmasi password tidak cocok',
      'password_confirmation.required' => 'Konfirmasi password wajib diisi',
    ]);
    
    // Ambil token dari session
    $token = session('reset_token');
    
    if (!$token) {
      return redirect('sesi/lupapw')->withErrors(['token' => 'Token tidak ditemukan, silahkan ulangi proses reset password.']);
    }
    
    // Cari data token pada tabel password_resets
    $resetPassword = DB::table('password_reset_tokens')->where('token', $token)->first();
    
    if (!$resetPassword) {
      return redirect('sesi/lupapw')->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
    }
    
    // Cari berdasarkan email yang terkait token
    $user = User::where('email', $resetPassword->email)->first();
    
    if (!$user) {
      return redirect('sesi/lupapw')->withErrors(['email' => 'User tidak ditemukan.']);
    }
    
    // Update password user
    $user->password = Hash::make($request->password);
    $user->save();
    
    // Hapus data token agar tidak bisa digunakan kembali
    DB::table('password_reset_tokens')->where('token', $token)->delete();

    // Hapus token dari session
    session()->forget('reset_token');

    return redirect('sesi')->with('status', 'Password berhasil diubah.');
  }
}
