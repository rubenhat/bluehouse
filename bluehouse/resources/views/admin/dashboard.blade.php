@extends('admin.layout')

@section('title', 'Dashboard - Manajemen Pesanan')

@section('content')
<div class="flex">

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 bg-gray-50 min-h-screen">

        <h1 class="text-2xl font-semibold mb-1">Dashboard - Manajemen Pesanan</h1>
        <p class="text-gray-600 mb-6">Pantau dan kelola pesanan secara real-time</p>

        <!-- CARDS -->
        <div class="grid grid-cols-4 gap-5 mb-8">

            <!-- Pending -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Pesanan Pending</p>
                    <span>⚠️</span>
                </div>
                <h2 class="text-3xl font-bold">{{ $pendingOrders }}</h2>
                <p class="text-sm text-gray-500">Menunggu konfirmasi</p>
            </div>

            <!-- Dikonfirmasi/Diproses -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Dikonfirmasi</p>
                    <span>📦</span>
                </div>
                <h2 class="text-3xl font-bold">{{ $processingOrders }}</h2>
                <p class="text-sm text-gray-500">Sedang diproses</p>
            </div>

            <!-- Selesai -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Selesai</p>
                    <span>✔️</span>
                </div>
                <h2 class="text-3xl font-bold text-green-600">{{ $readyOrders }}</h2>
                <p class="text-sm text-gray-500">Pesanan selesai</p>
            </div>

            <!-- Total Hari Ini -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Total Hari Ini</p>
                    <span>🛒</span>
                </div>
                <h2 class="text-3xl font-bold">{{ $todayOrders }}</h2>
                <p class="text-sm text-gray-500">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>

        </div>

        <!-- PESANAN AKTIF -->
        <div class="bg-white rounded-xl p-6 shadow-sm mb-8">
            <h2 class="text-lg font-semibold mb-4">Pesanan Aktif</h2>

            @forelse($activeOrders as $order)
            <div class="border rounded-xl p-5 mb-4">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">
                            {{ $order->order_id }}
                            <span class="text-xs px-2 py-1 rounded
                                @if($order->status === 'pending') bg-yellow-200 text-yellow-800
                                @elseif($order->status === 'confirmed') bg-blue-200 text-blue-800
                                @elseif($order->status === 'completed') bg-green-200 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-200 text-red-800
                                @endif">
                                @if($order->status === 'pending') Pending
                                @elseif($order->status === 'confirmed') Dikonfirmasi
                                @elseif($order->status === 'completed') Selesai
                                @elseif($order->status === 'cancelled') Dibatalkan
                                @endif
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->customer_phone }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->visitors_count }} pengunjung</p>
                    </div>
                </div>

                <div class="mt-4 flex space-x-2">
                    @if($order->status === 'pending')
                        <!-- Konfirmasi Button -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700"
                                    onclick="return confirm('Konfirmasi pesanan ini?')">
                                ✓ Konfirmasi Pesanan
                            </button>
                        </form>

                        <!-- Batalkan Button -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Batalkan pesanan ini?')">
                                ❌ Batalkan
                            </button>
                        </form>

                    @elseif($order->status === 'confirmed')
                        <!-- Selesaikan Button -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit"
                                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700"
                                    onclick="return confirm('Selesaikan pesanan ini?')">
                                ✅ Selesaikan
                            </button>
                        </form>

                        <!-- Batalkan Button -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Batalkan pesanan ini?')">
                                ❌ Batalkan
                            </button>
                        </form>

                    @elseif($order->status === 'completed')
                        <div class="w-full bg-green-100 text-green-800 py-2 px-4 rounded-lg text-center">
                            ✅ Pesanan Selesai
                        </div>

                    @elseif($order->status === 'cancelled')
                        <div class="w-full bg-red-100 text-red-800 py-2 px-4 rounded-lg text-center">
                            ❌ Pesanan Dibatalkan
                        </div>
                    @endif
                </div>

                <!-- Ringkasan Item -->
                @if($order->orderItems->count() > 0)
                <div class="mt-3 pt-3 border-t">
                    <p class="text-sm font-medium text-gray-700 mb-2">Item:</p>
                    @foreach($order->orderItems->take(3) as $item)
                        <p class="text-xs text-gray-600">{{ $item->quantity }}x {{ $item->product_name }}</p>
                    @endforeach
                    @if($order->orderItems->count() > 3)
                        <p class="text-xs text-gray-500">... dan {{ $order->orderItems->count() - 3 }} item lainnya</p>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                <p>Tidak ada pesanan aktif</p>
            </div>
            @endforelse

        </div>

        <!-- ITEM TERLARIS -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-6">Item Terlaris Hari Ini</h2>

            <div class="space-y-4">
                @forelse($topItems as $index => $item)
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full">{{ $index + 1 }}</div>
                        <div>
                            <p class="font-semibold">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-500">{{ $item->total_sold }} porsi terjual</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</p>
                        @if($item->menu)
                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ $item->menu->category ?? 'umum' }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <p>Belum ada penjualan hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

    </main>

</div>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-alert">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
</script>
@endif

@endsection
