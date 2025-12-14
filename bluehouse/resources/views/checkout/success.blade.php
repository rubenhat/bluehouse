@extends('layout.layout')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="max-w-md mx-auto px-4">

        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-500 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pesanan Berhasil!</h1>
            <p class="text-gray-600">Terima kasih atas pesanan Anda</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nomor Pesanan</span>
                    <span class="font-semibold">{{ $order->order_id }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Pemesan</span>
                    <span class="font-medium">{{ $order->customer_name }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">WhatsApp</span>
                    <span class="font-medium">{{ $order->customer_phone }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah Pengunjung</span>
                    <span class="font-medium">{{ $order->visitors_count }} orang</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Pending</span>
                </div>

                @if($order->notes)
                <div class="pt-3 border-t">
                    <span class="text-gray-600 block mb-1">Catatan:</span>
                    <span class="text-sm">{{ $order->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h2>

            <div class="space-y-3">
                @foreach($order->orderItems as $item)
                <div class="flex justify-between items-center py-2">
                    <div>
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        @if($item->note)
                            <p class="text-xs text-blue-600">{{ $item->note }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach

                <div class="border-t pt-3 mt-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 rounded-2xl p-6 mb-6">
            <h3 class="font-semibold text-blue-900 mb-3">Langkah Selanjutnya:</h3>
            <div class="space-y-2 text-sm text-blue-800">
                <div class="flex items-start">
                    <span class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">1</span>
                    <p>Tim kami akan menghubungi Anda melalui WhatsApp dalam 10-15 menit untuk konfirmasi</p>
                </div>
                <div class="flex items-start">
                    <span class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">2</span>
                    <p>Konfirmasi detail pesanan dan metode pembayaran</p>
                </div>
                <div class="flex items-start">
                    <span class="bg-blue-200 text-blue-900 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">3</span>
                    <p>Pesanan akan disiapkan setelah pembayaran dikonfirmasi</p>
                </div>
            </div>
        </div>

        <!-- Contact WhatsApp Button -->
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}?text=Halo%2C%20saya%20ingin%20menanyakan%20pesanan%20dengan%20ID%20{{ $order->order_id }}.%20Mohon%20konfirmasi%20pesanan%20saya."
           target="_blank"
           class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-4 rounded-xl font-semibold text-center block mb-4 transition-colors">
            <i class="fab fa-whatsapp mr-2"></i>
            Hubungi via WhatsApp
        </a>

        <!-- Back to Menu -->
        <a href="{{ route('menu.index') }}"
           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-4 rounded-xl font-semibold text-center block transition-colors">
            Kembali ke Menu
        </a>

    </div>
</div>
@endsection
