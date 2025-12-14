<style>
    /* CSS Kustom di dalam komponen header */
    .navbar-link {
        border-bottom: 2px solid transparent;
        transition: border-color 0.15s ease, color 0.15s ease;
    }
    .navbar-link:hover {
        border-color: #3b82f6; /* Tailwind Blue-500 */
        color: #3b82f6; /* Tailwind Blue-500 */
    }

    /* Cart badge styles */
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444; /* Red-500 */
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        min-width: 20px;
        animation: bounce 0.3s ease-in-out;
    }

    .cart-badge.hidden {
        display: none;
    }

    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: scale(1);
        }
        40%, 43% {
            transform: scale(1.2);
        }
        70% {
            transform: scale(1.1);
        }
        90% {
            transform: scale(1.05);
        }
    }

    .cart-icon-container {
        position: relative;
        display: inline-block;
    }
</style>

<header class="absolute top-0 left-0 w-full z-30 bg-white shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">

        <!-- Logo/Nama Brand (Kiri) -->
        <div class="flex-shrink-0">
            <a href="/" class="text-xl font-bold text-blue-600 tracking-wider">
                Blue House Farm
            </a>
        </div>

        <!-- Tautan Navigasi (Tengah) -->
        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="#" class="navbar-link text-gray-700 inline-flex items-center px-1 pt-1 text-base font-medium">
                Home
            </a>
            <a href="#menu" class="navbar-link text-gray-700 inline-flex items-center px-1 pt-1 text-base font-medium">
                Menu
            </a>
        </div>

        <!-- Ikon Aksi (Kanan) -->
        <div class="flex items-center space-x-6">
            <!-- Ikon Telepon/Pesan (Gelas Kopi) -->
            <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Pesan Antar">
                <i data-lucide="coffee" class="w-6 h-6"></i>
            </a>

            <!-- Ikon Keranjang Belanja dengan Badge -->
            <a href="{{ route('cart.index') }}"
                 class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100 cart-icon-container"
                 title="Keranjang Belanja">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                <!-- Cart Badge -->
                <span id="cart-badge" class="cart-badge {{ (session('cart') && count(session('cart')) > 0) ? '' : 'hidden' }}">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>

            <!-- Tombol Mobile Menu -->
            <button type="button" class="sm:hidden text-gray-600 hover:text-blue-600 p-2 rounded-full hover:bg-gray-100" aria-controls="mobile-menu" aria-expanded="false">
                 <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </nav>
</header>

<script>
    // Function untuk update cart badge
    function updateCartBadge() {
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cart-badge');
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.classList.remove('hidden');
                // Add bounce animation
                badge.style.animation = 'none';
                setTimeout(() => {
                    badge.style.animation = 'bounce 0.3s ease-in-out';
                }, 10);
            } else {
                badge.classList.add('hidden');
            }
        })
        .catch(error => console.error('Error updating cart badge:', error));
    }

    // Update badge when page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
    });

    // Listen for custom cart update events
    document.addEventListener('cartUpdated', function() {
        updateCartBadge();
    });
</script>

{{-- lucide.createIcons() akan dipanggil di layout.blade.php setelah body ditutup --}}
