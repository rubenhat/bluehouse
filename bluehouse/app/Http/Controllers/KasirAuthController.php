<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirAuthController extends Controller
{

    private $kasirEmail = "kasir@bluehouse.com";
    private $kasirPassword = "kasir123";

        public function showLogin()
    {
        return view('kasir.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($request->email === $this->kasirEmail && $request->password === $this->kasirPassword) {
            session(['kasir_logged_in' => true]);
            return redirect()->route('kasir.pesanan');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
{
    // Hapus session login admin
    $request->session()->forget('kasir_logged_in');

    // Optional: hapus semua session
    // $request->session()->flush();

    return redirect()->route('kasir.login')
        ->with('success', 'Anda berhasil logout');
}
}
