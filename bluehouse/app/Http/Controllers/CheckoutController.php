<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'visitors' => 'required|integer|min:1'
        ]);

        // Data checkout
        $checkoutData = [
            'name' => $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'visitors' => $req->visitors,
            'cart' => session('cart'),
            'total' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], session('cart')))
        ];

        // Simpan ke session (atau bisa ke database nanti)
        session(['checkout' => $checkoutData]);

        return redirect()->route('checkout.success');
    }
}
