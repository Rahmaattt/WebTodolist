<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SessionController extends Controller
{
  public function index() {
      return view("sesi/index");
  }
    
  public function lupaPw() {
    return view("sesi/lupapw");
  }
  
  public function updatePw() {
    return view("sesi/updatepw");
  }
    
  public function register() {
    return view("sesi/register");
  }
    
    public function storeRegister(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
          'email.required' => 'Email wajib diisi',
          'email.email' => 'Email tidak valid',
          'password.required' => 'Password wajib diisi',
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/sesi')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
    
    
    
    function login(Request $request) {
      $request->validate([
        'name'=>'required',
        'email'=>'required',
        'password'=>'required'
      ],[
        'name.required'=>'nama wajib diisi',
        'email.required'=>'email wajib diisi',
        'password.required'=>'password wajib diisi'
     ]);
     
     $infologin = [
       'name'=>$request->name,
       'email'=>$request->email,
       'password'=>$request->password,
       ];
       
       if(Auth::attempt($infologin)) {
         return redirect('/dashboard')->with('success', 'Pendaftaran berhasil! Silakan login.');
       } else {
         return 'gagal';
       }
    }
  
  public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/sesi')->with('success', 'Anda telah keluar.');
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

    if (Auth::attempt($user)) {
      return redirect("/sesi/updatepw");
    } else {
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
  }
  
  public function updatePwPost(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required',
    ], [
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password harus minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi',
    ]);
    
    //$user = auth()->user()->id_user;
    
    $user = User::find(auth()->user()->id_user);
    if ($user) {
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/dashboard')->with('status', 'Password berhasil diperbarui');
    }
    return back()->withErrors(['error' => 'Terjadi kesalahan, coba lagi nanti']);
  }
}