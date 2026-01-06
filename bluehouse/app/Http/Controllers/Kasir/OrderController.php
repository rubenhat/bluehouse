<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
        public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        // Calculate statistics
        $statistics = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            
        ];

        // Get orders based on status filter
        $query = Order::with('orderItems')->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10);

        return view('kasir.pesanan', compact('orders', 'status', 'statistics'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        try {
            // Validate request
            $request->validate([
                'status' => 'required|in:pending,confirmed,paid,completed,cancelled'
            ]);

            // Find order
            $order = Order::findOrFail($orderId);
            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Update order status
            $order->status = $newStatus;
            $order->save();

            // Log the update
            Log::info("Order status updated", [
                'order_id' => $order->id,
                'order_number' => $order->order_id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);

            // Success messages
            $messages = [
                'confirmed' => 'Pesanan berhasil dikonfirmasi!',
                'completed' => 'Pesanan berhasil diselesaikan!',
                'paid' => 'Pesanan berhasil dibayar!',
                'cancelled' => 'Pesanan berhasil dibatalkan!',
                'pending' => 'Pesanan dikembalikan ke status pending!'
            ];

            return redirect()->route('kasir.pesanan.index', ['status' => $request->get('current_status', 'all')])
                            ->with('success', $messages[$newStatus] ?? 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error("Error updating order status", [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate status pesanan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load('orderItems');
        return view('kasir.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->route('kasir.pesanan.index')
                            ->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pesanan!');
        }
    }
}
