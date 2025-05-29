<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $data = $request->input();
        $try = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($try) {
            // $request->session()->regenerate();
            $request->session()->flash('modal-title', 'Berhasil');
            $request->session()->flash('modal-text', 'Selamat Anda Berhasil Login');
            $request->session()->flash('modal-icon', 'success');

            $role = Auth::user()->roles[0]['name'];

            switch ($role) {
                case 'petugas': {
                    return redirect()->route('cars.index');
                }
                case 'admin': {
                    return redirect()->route('books.index');
                }
                default: {
                    return redirect()->route('index');
                }
            }
        }

        $request->session()->flash('message-type', 'failed');
        $request->session()->flash('message', 'Email / Password yang anda masukan salah');
        return redirect()->route('login');
    }

    function loginView(Request $request)
    {
        return view('auth.login');
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Berhasil Keluar. Sampai Jumpa');
        return redirect()->route('login');
    }
}
