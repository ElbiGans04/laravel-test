<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', function () {
        // return view('welcome');
        return view('index');
    })->name('index');

    Route::get('/roles', function () {
        // return view('welcome');
        return view('roles');
    })->name('roles');

    Route::get('/permission', function () {
        // return view('welcome');
        return view('permission');
    })->name('permission');
});

Route::group(['prefix' => '/auth'], function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Berhasil Keluar. Sampai Jumpa');
        return redirect()->route('login');
    })->name('logout');

    Route::post('/login', function (Request $request) {
        $data = $request->input();
        $try = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($try) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        $request->session()->flash('message-type', 'failed');
        $request->session()->flash('message', 'Email / Password yang anda masukan salah');
        return redirect()->route('login');
    })->name('login.post');
});
