<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.login', [
            'title' => 'Login'
        ]);
    }

    // Login
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => 'Email ini belum tersedia',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Alert::success('Login Success', 'User Login Success!');

            return redirect()->intended(route('user.index'))->with('success', 'User Login Success!');
        }


        Alert::error('Login Gagal', 'Email atau Password salah');
        return redirect()->back()->with('error', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Alert::success('Logout Success', 'User Logout Success!');
        return redirect('/')->with('logout', 'User Logout Success!');
    }
}
