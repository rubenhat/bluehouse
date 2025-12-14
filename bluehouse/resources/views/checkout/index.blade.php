@extends('layout.layout')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="max-w-md mx-auto px-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('cart.index') }}" class="p-2 hover:bg-gray-100 rounded-full">
                <i class="fas fa-arrow-left text-xl text-gray-700"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-900">Checkout</h1>
            <div class="w-10"></div> <!-- Spacer -->
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap *
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama Anda"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor WhatsApp *
                        </label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="Contoh: 08123456789"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email (Opsional)
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Alamat email (opsional)"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="visitors" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Pengunjung *
                        </label>
                        <input type="number"
                               id="visitors"
                               name="visitors"
                               value="{{ old('visitors', 1) }}"
                               min="1"
                               max="50"
                               placeholder="Masukkan jumlah orang"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visitors') border-red-500 @enderror"
                               required>
                        @error('visitors')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                <div class="space-y-4 mb-6">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; @endphp
                        @php $total += $subtotal; @endphp

                        <div class="flex items-center space-x-4 py-3 border-b border-gray-100 last:border-b-0">
                            <div class="flex-shrink-0">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                         alt="{{ $item['name'] }}"
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $item['quantity'] }}x</p>
                                @if(!empty($item['note']))
                                    <p class="text-xs text-blue-600 mt-1">{{ $item['note'] }}</p>
                                @endif
                            </div>

                            <div class="text-right">
                                <p class="font-medium text-gray-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Layanan</span>
                            <span>Rp 0</span>
                        </div>
                        <hr class="my-3">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Catatan Tambahan</h2>
                <textarea name="notes"
                          id="notes"
                          placeholder="Tambahkan catatan khusus untuk pesanan Anda (opsional)"
                          class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          rows="3">{{ old('notes') }}</textarea>
            </div>

            <!-- Terms -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Dengan melanjutkan, Anda menyetujui bahwa tim kami akan menghubungi Anda melalui WhatsApp untuk konfirmasi pesanan dan pembayaran.
                </p>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    id="submit-btn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl font-semibold text-lg shadow-lg transition-colors">
                <span id="submit-text">Konfirmasi Pesanan</span>
                <span id="loading-text" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Memproses...
                </span>
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const loadingText = document.getElementById('loading-text');

    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    loadingText.classList.remove('hidden');
});

// Format phone number input
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        e.target.value = value;
    } else if (value.startsWith('62')) {
        e.target.value = '0' + value.substring(2);
    } else if (value.length > 0) {
        e.target.value = '0' + value;
    }
});
</script>

@endsection
