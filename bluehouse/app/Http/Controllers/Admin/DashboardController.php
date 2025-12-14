<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics berdasarkan status yang benar
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'confirmed')->count(); // confirmed = sedang diproses
        $readyOrders = Order::where('status', 'completed')->count(); // completed = siap/selesai

        // Today's orders and revenue
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::whereDate('created_at', Carbon::today())->sum('total_amount');

        // Active orders (pending dan confirmed)
        $activeOrders = Order::whereIn('status', ['pending', 'confirmed'])
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top items today
        $topItems = OrderItem::whereHas('order', function($query) {
                $query->whereDate('created_at', Carbon::today());
            })
            ->with('menu')
            ->select('product_name', 'menu_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->selectRaw('SUM(subtotal) as total_revenue')
            ->groupBy('product_name', 'menu_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingOrders',
            'processingOrders',
            'readyOrders',
            'todayOrders',
            'todayRevenue',
            'activeOrders',
            'topItems'
        ));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate');
    }
}
