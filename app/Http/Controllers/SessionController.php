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


class SessionController extends Controller
{
  public function index() {
      return view("sesi/index");
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

        return redirect('/')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
    
    
    
    function login(Request $request) {
      $request->validate([
        'login'=>'required',
        'password'=>'required'
      ],[
        'login.required'=>'username atau password wajib diisi',
        'password.required'=>'password wajib diisi'
      ]);
     
      $login    = $request->login;
      $password = $request->password;
      
      $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
      
      $credentials = [
        $fieldType => $login,
        'password' => $password
    ];
      
      if(Auth::attempt($credentials)) {
        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil! Silakan login.');
      } else {
        return 'gagal';
      }
    }
  
  public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Anda telah keluar.');
  }
}