<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $req)
    {
        $menu = Menu::findOrFail($req->menu_id);

        $cart = session('cart', []);

        if (!isset($cart[$menu->id])) {
            $cart[$menu->id] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => 1,
                'note' => '',
                'image' => $menu->image,
            ];
        } else {
            $cart[$menu->id]['qty'] += 1;
        }

        session(['cart' => $cart]);

        return back();
    }

    public function update(Request $req)
    {
        $cart = session('cart', []);

        if (isset($cart[$req->id])) {
            $cart[$req->id]['qty'] = max(1, $req->qty);
        }

        session(['cart' => $cart]);

        return back();
    }

    public function note(Request $req)
    {
        $cart = session('cart', []);

        if (isset($cart[$req->id])) {
            $cart[$req->id]['note'] = $req->note;
        }

        session(['cart' => $cart]);

        return back();
    }
}
