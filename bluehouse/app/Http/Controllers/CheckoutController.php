<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'visitors' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }

        try {
            // Generate order ID
            $orderId = 'BH' . date('ymdHis');

            // Hitung total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Buat order baru
            $order = Order::create([
                'order_id' => $orderId,
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'customer_email' => $request->email,
                'visitors_count' => $request->visitors,
                'total_amount' => $total,
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            // Simpan order items
            foreach ($cart as $menuId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menuId,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'note' => $item['note'] ?? null
                ]);
            }

            // Hapus cart setelah berhasil
            Session::forget('cart');

            // Redirect ke halaman sukses
            return redirect()->route('checkout.success', ['order' => $order->order_id])
                           ->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    public function success($orderId)
    {
        $order = Order::where('order_id', $orderId)->with('orderItems')->first();

        if (!$order) {
            return redirect()->route('menu.index')->with('error', 'Pesanan tidak ditemukan!');
        }

        // Ambil order items untuk kompatibilitas dengan view yang ada
        $orderItems = $order->orderItems;

        return view('checkout.success', compact('order', 'orderItems'));
    }
}
