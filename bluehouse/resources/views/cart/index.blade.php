@extends('layout.layout')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="max-w-md mx-auto px-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('menu.index') }}" class="p-2 hover:bg-gray-100 rounded-full">
                <i class="fas fa-arrow-left text-xl text-gray-700"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-900">Keranjang Belanja</h1>
            <div class="w-10"></div> <!-- Spacer -->
        </div>

        @if(empty($cartItems))
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-6">Belum ada item di keranjang Anda</p>
                <a href="{{ route('menu.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Mulai Belanja</span>
                </a>
            </div>
        @else
            <!-- Cart Items -->
            <div class="space-y-4">
                @foreach($cartItems as $id => $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4" id="cart-item-{{ $id }}">
                        <div class="flex items-start space-x-4">
                            <!-- Item Image -->
                            <div class="flex-shrink-0">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                         alt="{{ $item['name'] }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Item Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $item['name'] }}</h3>
                                        <p class="text-lg font-bold text-blue-600 mt-1">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- Delete Button (Lebih Prominent) -->
                                    <button onclick="removeFromCart({{ $id }})"
                                            class="ml-2 p-2 text-red-500 hover:bg-red-50 rounded-full transition-colors duration-200 hover:text-red-600"
                                            title="Hapus dari keranjang">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center justify-between mt-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center space-x-3">
                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
                                        class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus text-sm text-gray-600"></i>
                                </button>

                                <span class="text-lg font-semibold w-8 text-center">{{ $item['quantity'] }}</span>

                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                                        class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-plus text-sm text-gray-600"></i>
                                </button>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Subtotal</p>
                                <p class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Alternative Delete Button (Text Button) -->
                        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                            <button onclick="toggleNote({{ $id }})"
                                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                                <i class="fas fa-sticky-note"></i>
                                <span>Tambah catatan</span>
                            </button>

                            <!-- Alternative Delete Button (if you prefer text) -->
                            <button onclick="removeFromCart({{ $id }})"
                                    class="text-sm text-red-500 hover:text-red-700 flex items-center space-x-1 transition-colors">
                                <i class="fas fa-trash-alt"></i>
                                <span>Hapus Item</span>
                            </button>
                        </div>

                        <div id="note-section-{{ $id }}" class="hidden mt-2">
                            <textarea id="note-{{ $id }}"
                                      placeholder="Contoh: Pedas level 1, tanpa bawang..."
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      rows="2">{{ $item['note'] ?? '' }}</textarea>
                            <div class="flex space-x-2 mt-2">
                                <button onclick="saveNote({{ $id }})"
                                        class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                                <button onclick="cancelNote({{ $id }})"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Promo Code Section -->
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center space-x-3">
                    <input type="text"
                           id="promoCode"
                           placeholder="Masukkan kode promo"
                           class="flex-1 border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button onclick="applyPromo()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Terapkan
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <h3 class="font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Layanan</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Diskon</span>
                        <span class="text-red-500">-Rp 0</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total Pembayaran</span>
                        <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Fixed Bottom Checkout Button -->
@if(!empty($cartItems))
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <div class="text-left">
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('checkout.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold text-lg shadow-lg transition-colors">
                Lanjut ke Checkout
            </a>
        </div>
    </div>
@endif

<!-- Toast Container -->
<div id="toast-container" class="fixed top-20 right-4 z-50"></div>

<script>
// Update quantity dengan animasi
function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) return;

    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: itemId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Quantity berhasil diupdate', 'success');
            // Update cart badge jika ada
            if (typeof updateCartBadge === 'function') {
                updateCartBadge();
            }
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast('Gagal mengupdate quantity', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

// Remove item dari cart dengan konfirmasi dan animasi
function removeFromCart(itemId) {
    // Konfirmasi dengan dialog yang lebih menarik
    if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        return;
    }

    // Disable button sementara
    const deleteButtons = document.querySelectorAll(`[onclick="removeFromCart(${itemId})"]`);
    deleteButtons.forEach(btn => {
        btn.disabled = true;
        btn.style.opacity = '0.5';
    });

    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: itemId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Item berhasil dihapus dari keranjang', 'success');

            // Animasi fade out
            const cartItem = document.getElementById(`cart-item-${itemId}`);
            if (cartItem) {
                cartItem.style.transition = 'all 0.3s ease';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(100%)';

                setTimeout(() => {
                    cartItem.remove();
                }, 300);
            }

            // Update cart badge jika ada
            if (typeof updateCartBadge === 'function') {
                updateCartBadge();
            }

            // Reload setelah animasi selesai
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast('Gagal menghapus item', 'error');
            // Re-enable buttons
            deleteButtons.forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
        // Re-enable buttons
        deleteButtons.forEach(btn => {
            btn.disabled = false;
            btn.style.opacity = '1';
        });
    });
}

// Toggle note section
function toggleNote(itemId) {
    const noteSection = document.getElementById(`note-section-${itemId}`);
    noteSection.classList.toggle('hidden');
}

// Save note
function saveNote(itemId) {
    const note = document.getElementById(`note-${itemId}`).value;

    fetch('{{ route("cart.note") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: itemId,
            note: note
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Catatan berhasil disimpan', 'success');
            document.getElementById(`note-section-${itemId}`).classList.add('hidden');
        } else {
            showToast('Gagal menyimpan catatan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

// Cancel note
function cancelNote(itemId) {
    document.getElementById(`note-section-${itemId}`).classList.add('hidden');
}

// Apply promo code
function applyPromo() {
    const promoCode = document.getElementById('promoCode').value;

    if (!promoCode) {
        showToast('Masukkan kode promo', 'error');
        return;
    }

    fetch('{{ route("cart.promo") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            promo_code: promoCode
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Promo berhasil diterapkan', 'success');
            location.reload();
        } else {
            showToast(data.message || 'Kode promo tidak valid', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

// Show toast notification dengan style yang lebih baik
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `p-4 rounded-lg shadow-lg mb-2 transition-all transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    document.getElementById('toast-container').appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}
</script>

@endsection
