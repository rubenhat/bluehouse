<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $menu = Menu::findOrFail($request->menu_id);

            if (!($menu->is_available ?? true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak tersedia'
                ]);
            }

            $cart = session()->get('cart', []);
            $menuId = $request->menu_id;

            if (isset($cart[$menuId])) {
                $cart[$menuId]['quantity'] += $request->quantity;
            } else {
                $cart[$menuId] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'image' => $menu->image,
                    'quantity' => $request->quantity,
                    'note' => ''
                ];
            }

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan ke keranjang',
                'count' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = session()->get('cart', []);
            $itemId = $request->id;

            if (isset($cart[$itemId])) {
                $cart[$itemId]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Quantity berhasil diupdate'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $cart = session()->get('cart', []);
            $itemId = $request->id;

            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function addNote(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'note' => 'nullable|string|max:255'
            ]);

            $cart = session()->get('cart', []);
            $itemId = $request->id;

            if (isset($cart[$itemId])) {
                $cart[$itemId]['note'] = $request->note;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Catatan berhasil disimpan'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function applyPromo(Request $request)
    {
        try {
            $request->validate([
                'promo_code' => 'required|string'
            ]);

            // Dummy promo logic - you can expand this
            $validPromoCodes = [
                'DISKON10' => 10,
                'HEMAT20' => 20,
                'NEWUSER' => 15
            ];

            $promoCode = strtoupper($request->promo_code);

            if (isset($validPromoCodes[$promoCode])) {
                session()->put('promo_code', $promoCode);
                session()->put('promo_discount', $validPromoCodes[$promoCode]);

                return response()->json([
                    'success' => true,
                    'message' => 'Promo berhasil diterapkan',
                    'discount' => $validPromoCodes[$promoCode]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('promo_code');
        session()->forget('promo_discount');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function getCartCount()
    {
        $cart = session('cart', []);
        $totalItems = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        return response()->json([
            'count' => $totalItems
        ]);
    }

    public function addToCart(Request $request)
    {
        // ...existing cart logic...

        // Jika ini AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang!',
                'count' => $this->getCartItemCount()
            ]);
        }

        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    private function getCartItemCount()
    {
        $cart = session('cart', []);
        $totalItems = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        return $totalItems;
    }

    public function removeFromCart($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        // Trigger cart update event
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $this->getCartItemCount()
            ]);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = session('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            session(['cart' => $cart]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $this->getCartItemCount()
            ]);
        }

        return redirect()->back();
    }
}
