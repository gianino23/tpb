<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function depan() 
    {
        if(!Auth::user()){
        return view('auth.depan');
        }else{
            return view('auth.depann');
        }
    }
    public function login() 
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }else{
            return view('auth.login');
        }
    }
    public function comingsoon()
    {
        return view('auth.comingsoon');
    }

    public function postlogin(Request $request) {
        if(Auth::attempt($request->only('email','password'))){
            return redirect('/dashboard');
        }else{           
            return redirect('/')
            ->withInput()
            ->withErrors(['login_gagal'=>'Email dan Password Anda Salah']);
        }
        return redirect('/');
        
    }
    
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
