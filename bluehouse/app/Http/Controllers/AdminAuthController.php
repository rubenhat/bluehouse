<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    private $adminEmail = "admin@bluehouse.com";
    private $adminPassword = "admin123";

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($request->email === $this->adminEmail && $request->password === $this->adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
{
    // Hapus session login admin
    $request->session()->forget('admin_logged_in');

    // Optional: hapus semua session
    // $request->session()->flush();

    return redirect()->route('admin.login')
        ->with('success', 'Anda berhasil logout');
}

}
