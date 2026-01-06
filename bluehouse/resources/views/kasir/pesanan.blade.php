@extends('kasir.layout')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="flex">
    <main class="flex-1 p-10 bg-gray-50 min-h-screen">

        <h1 class="text-2xl font-semibold mb-1">Manajemen Pesanan</h1>
        <p class="text-gray-600 mb-6">Kelola dan masak pesanan</p>

        <!-- DAFTAR PESANAN -->
        <div class="space-y-4">
            @forelse($orders as $order)
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <!-- HEADER PESANAN -->
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $order->order_id }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->customer_phone }}</p>
                        @if($order->customer_email)
                            <p class="text-xs text-gray-400">{{ $order->customer_email }}</p>
                        @endif
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }} ({{ $order->created_at->diffForHumans() }})</p>
                        <p class="text-xs text-gray-500">Pengunjung: {{ $order->visitors_count }} orang</p>
                    </div>

                    <div class="text-right">

                        <!-- TOGGLE DETAIL BUTTON -->
                        <div>
                            <button onclick="toggleDetail('order-{{ $order->id }}')"
                                    class="text-sm px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                                <span id="toggle-text-{{ $order->id }}">Detail</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- DETAIL PESANAN (COLLAPSIBLE) -->
                <div id="order-{{ $order->id }}" class="hidden border-t pt-4 mb-4">

                    <!-- INFORMASI LENGKAP -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Informasi Pesanan</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Nomor Pesanan:</span>
                                <span class="font-medium ml-2">{{ $order->order_id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium ml-2">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Nama Customer:</span>
                                <span class="font-medium ml-2">{{ $order->customer_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">No. WhatsApp:</span>
                                <span class="font-medium ml-2">{{ $order->customer_phone }}</span>
                            </div>
                            @if($order->customer_email)
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium ml-2">{{ $order->customer_email }}</span>
                            </div>
                            @endif
                            <div>
                                <span class="text-gray-600">Jumlah Pengunjung:</span>
                                <span class="font-medium ml-2">{{ $order->visitors_count }} orang</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Waktu Pesan:</span>
                                <span class="font-medium ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Status Pembayaran:</span>
                                <span class="font-medium ml-2">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="mt-3 pt-3 border-t">
                            <span class="text-gray-600">Catatan:</span>
                            <span class="font-medium ml-2">{{ $order->notes }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- DETAIL ITEM PESANAN -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Detail Item</h4>
                        <div class="space-y-3">
                            @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center border-b pb-3">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $item->product_name }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span>Qty: {{ $item->quantity }}</span>
                                        <span>Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        @if($item->menu && $item->menu->category)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ ucfirst($item->menu->category) }}</span>
                                        @endif
                                    </div>
                                    @if($item->note)
                                        <p class="text-xs text-blue-600 mt-1">Note: {{ $item->note }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TOTAL PEMBAYARAN -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total Pembayaran:</span>
                            <span class="text-xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS IN DETAIL -->
                    <div class="flex space-x-3 mb-4">

                        @if($order->status === 'pending')
                            <!-- Konfirmasi -->
                            <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <input type="hidden" name="current_status" value="{{ $status }}">
                                <button type="submit"
                                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold"
                                        onclick="return confirm('Konfirmasi pesanan ini? Order ID: {{ $order->id }}')">
                                    ✓ Konfirmasi Pesanan
                                </button>
                            </form>

                            <!-- Batalkan -->
                            <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="current_status" value="{{ $status }}">
                                <button type="submit"
                                        class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold"
                                        onclick="return confirm('Batalkan pesanan ini? Order ID: {{ $order->id }}')">
                                    ❌ Batalkan Pesanan
                                </button>
                            </form>

                        @elseif($order->status === 'completed')
                            <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center w-full">
                                ✅ Pesanan Telah Selesai
                            </div>

                        @elseif($order->status === 'cancelled')
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg text-center w-full">
                                ❌ Pesanan Dibatalkan
                            </div>
                        @endif
                    </div>

                    <!-- WhatsApp Contact Button -->
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}?text=Halo%20{{ urlencode($order->customer_name) }},%20terima%20kasih%20sudah%20memesan%20di%20Blue%20House%20Farm.%20Pesanan%20Anda%20dengan%20ID%20{{ $order->order_id }}%20sedang%20kami%20proses."
                           target="_blank"
                           class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </a>

                </div>

                <!-- RINGKASAN ITEM (ALWAYS VISIBLE) -->
                <div class="space-y-2 mb-4">
                    <h5 class="font-medium text-gray-700">Ringkasan Item:</h5>
                    @foreach($order->orderItems->take(3) as $item)
                    <div class="flex justify-between text-sm">
                        <div>
                            <span class="font-medium">{{ $item->quantity }}x {{ $item->product_name }}</span>
                            @if($item->note)
                                <span class="text-xs text-blue-500 block">Note: {{ $item->note }}</span>
                            @endif
                        </div>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    @if($order->orderItems->count() > 3)
                    <div class="text-sm text-gray-500">
                        ... dan {{ $order->orderItems->count() - 3 }} item lainnya
                    </div>
                    @endif
                </div>

                <!-- FOOTER DENGAN TOTAL DAN QUICK ACTIONS -->
                <div class="border-t pt-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-lg">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->visitors_count }} pengunjung</p>
                        @if($order->notes)
                        <p class="text-xs text-gray-500 mt-1">Catatan: {{ $order->notes }}</p>
                        @endif
                    </div>

                    <div class="flex space-x-2">
                        <!-- QUICK ACTION BUTTONS (SMALL) -->
                        @if($order->status === 'pending')
                            <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <input type="hidden" name="current_status" value="{{ $status }}">
                                <button type="submit"
                                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                        onclick="return confirm('Konfirmasi pesanan ini?')"
                                        title="Konfirmasi Pesanan">
                                    ✓ Konfirmasi
                                </button>
                            </form>
                            <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="current_status" value="{{ $status }}">
                                <button type="submit"
                                        class="px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700"
                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                        title="Batalkan Pesanan">
                                    ❌
                                </button>
                            </form>

                        @elseif($order->status === 'completed')
                            <span class="px-4 py-2 text-sm bg-green-100 text-green-800 rounded-lg">
                                ✅ Selesai
                            </span>

                        @elseif($order->status === 'cancelled')
                            <span class="px-4 py-2 text-sm bg-red-100 text-red-800 rounded-lg">
                                ❌ Dibatalkan
                            </span>
                        @endif

                        <!-- WhatsApp Quick Contact -->
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}"
                           target="_blank"
                           class="px-3 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600"
                           title="Chat WhatsApp">
                            💬
                        </a>

                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl p-12 shadow-sm text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak ada pesanan</h3>
                <p class="text-gray-500">
                    @if($status === 'all')
                    Belum ada pesanan yang masuk
                    @else
                    Tidak ada pesanan dengan status {{ $status }}
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->appends(['status' => $status])->links() }}
        </div>
        @endif

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

@if(session('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-alert">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
        </svg>
        {{ session('error') }}
    </div>
</div>
<script>
    setTimeout(function() {
        const alert = document.getElementById('error-alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
</script>
@endif

<script>
function toggleDetail(orderId) {
    const detailElement = document.getElementById(orderId);
    const toggleText = document.getElementById('toggle-text-' + orderId.replace('order-', ''));

    if (detailElement.classList.contains('hidden')) {
        detailElement.classList.remove('hidden');
        toggleText.textContent = 'Tutup';
    } else {
        detailElement.classList.add('hidden');
        toggleText.textContent = 'Detail';
    }
}
</script>

@endsection
