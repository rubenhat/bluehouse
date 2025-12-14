@extends('layout.layout')

@section('title', 'Menu')

@section('content')

<div class="px-6 py-6 max-w-7xl mx-auto mt-20">

    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Menu Kami</h1>
        <p class="text-gray-600">Pilih dari berbagai menu pilihan kami yang lezat dan berkualitas</p>
    </div>

    <!-- Category Filter -->
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        <a href="{{ route('menu.index') }}"
           class="px-6 py-2 rounded-full transition-colors {{ !request('category') || request('category') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Semua
        </a>
        <a href="{{ route('menu.index', ['category' => 'makanan']) }}"
           class="px-6 py-2 rounded-full transition-colors {{ request('category') == 'makanan' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Makanan
        </a>
        <a href="{{ route('menu.index', ['category' => 'minuman']) }}"
           class="px-6 py-2 rounded-full transition-colors {{ request('category') == 'minuman' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Minuman
        </a>
        <a href="{{ route('menu.index', ['category' => 'kopi']) }}"
           class="px-6 py-2 rounded-full transition-colors {{ request('category') == 'kopi' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Kopi
        </a>
        <a href="{{ route('menu.index', ['category' => 'dessert']) }}"
           class="px-6 py-2 rounded-full transition-colors {{ request('category') == 'dessert' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Dessert
        </a>
        <a href="{{ route('menu.index', ['category' => 'snack']) }}"
           class="px-6 py-2 rounded-full transition-colors {{ request('category') == 'snack' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Snack
        </a>
    </div>

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($menus as $menu)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                <!-- Image Container -->
                <div class="relative">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}"
                             alt="{{ $menu->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-utensils text-4xl text-gray-400"></i>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    @php
                        $badgeConfig = [
                            'makanan' => ['bg-green-500', 'Best Seller'],
                            'kopi' => ['bg-orange-500', 'Best Seller'],
                            'minuman' => ['bg-blue-500', 'Promo'],
                            'dessert' => ['bg-pink-500', 'Promo'],
                            'snack' => ['bg-yellow-500', 'Promo']
                        ];
                        $category = strtolower($menu->category ?? 'makanan');
                        $badge = $badgeConfig[$category] ?? ['bg-red-500', 'Promo'];
                    @endphp

                    <div class="absolute top-3 left-3">
                        <span class="{{ $badge[0] }} text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $badge[1] }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Menu Name -->
                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $menu->name }}</h3>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($menu->description ?? 'Deskripsi menu tidak tersedia', 60) }}
                    </p>

                    <!-- Category -->
                    <p class="text-sm text-gray-500 mb-3 capitalize">
                        {{ ucfirst($menu->category ?? 'makanan') }}
                    </p>

                    <!-- Price -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-xl font-bold text-gray-900">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                            @if($menu->price > 40000)
                            <span class="text-sm text-gray-400 line-through ml-2">
                                Rp {{ number_format($menu->price * 1.15, 0, ',', '.') }}
                            </span>
                            @endif
                        </div>
                        @if(!($menu->is_available ?? true))
                            <span class="text-xs text-red-600 font-medium">Habis</span>
                        @endif
                    </div>

                    <!-- Action Button -->
                    @if($menu->is_available ?? true)
                        <button onclick="addToCart({{ $menu->id }})"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-plus text-sm"></i>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    @else
                        <button disabled
                                class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-lg cursor-not-allowed">
                            Menu Habis
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-utensils text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-3">Menu Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6">
                    @if(request('search'))
                        Tidak ada menu yang cocok dengan pencarian "{{ request('search') }}"
                    @else
                        Belum ada menu yang tersedia untuk kategori ini
                    @endif
                </p>
                <a href="{{ route('menu.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Semua Menu</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if(isset($menus) && method_exists($menus, 'hasPages') && $menus->hasPages())
        <div class="mt-12 text-center">
            {{ $menus->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Floating Cart Button -->
<a href="{{ route('cart.index') }}"
   class="fixed bottom-5 right-5 bg-red-500 hover:bg-red-600 text-white p-4 rounded-full shadow-lg transition-all transform hover:scale-110 z-50">
    <div class="relative">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-yellow-400 text-red-500 text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
            0
        </span>
    </div>
</a>

<!-- Success/Error Messages -->
<div id="toast-container" class="fixed top-20 right-5 z-50"></div>

<script>
// Add to cart function
function addToCart(menuId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            menu_id: menuId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Menu berhasil ditambahkan ke keranjang!', 'success');
            updateCartCount();
        } else {
            showToast(data.message || 'Gagal menambahkan menu ke keranjang', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
    });
}

// Show toast notification
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

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Update cart count
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
    .then(response => response.json())
    .then(data => {
        document.getElementById('cart-count').textContent = data.count || 0;
    })
    .catch(error => {
        console.error('Error updating cart count:', error);
    });
}

// Load cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
</script>

@endsection
