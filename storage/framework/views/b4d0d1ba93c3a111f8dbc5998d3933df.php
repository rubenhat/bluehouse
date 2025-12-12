<style>
    /* CSS Kustom di dalam komponen header */
    .navbar-link {
        border-bottom: 2px solid transparent;
        transition: border-color 0.15s ease, color 0.15s ease;
    }
    .navbar-link:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    /* Cart badge styles - DIPERBAIKI */
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #ef4444;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        line-height: 1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        border: 2px solid white;
        animation: badge-appear 0.3s ease-out;
        z-index: 20;
    }

    @keyframes badge-appear {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Cart icon container - DIPERBAIKI */
    .cart-icon-container {
        position: relative;
        display: inline-block;
    }

    /* Ensure cart link is positioned relative */
    #cart-link {
        position: relative;
        display: inline-block;
    }
</style>

<header class="absolute top-0 left-0 w-full z-30 bg-white shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="/" class="text-xl font-bold text-blue-600 tracking-wider">
                Blue House Farm
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="/" class="navbar-link text-gray-700 inline-flex items-center px-1 pt-1 text-base font-medium">
                Home
            </a>
            <a href="<?php echo e(route('menu.index')); ?>" class="navbar-link text-gray-700 inline-flex items-center px-1 pt-1 text-base font-medium">
                Menu
            </a>
        </div>

        <!-- Action Icons -->
        <div class="flex items-center space-x-6">
            <!-- Coffee Icon -->
            <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Pesan Antar">
                <i data-lucide="coffee" class="w-6 h-6"></i>
            </a>

            <!-- Cart Icon dengan Badge - DIPERBAIKI STRUKTUR -->
            <div class="cart-icon-container">
                <a href="<?php echo e(route('cart.index')); ?>" id="cart-link"
                   class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Keranjang Belanja">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <!-- Badge di dalam link, bukan di luar -->
                    <span id="cart-badge" class="cart-badge hidden">0</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button type="button" class="sm:hidden text-gray-600 hover:text-blue-600 p-2 rounded-full hover:bg-gray-100">
                 <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </nav>
</header>

<!-- Initialize Lucide and Cart Functions -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Initialize cart count
    updateCartCount();
});

// Function to update cart count - DIPERBAIKI
function updateCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.textContent = data.count || 0;
            if (data.count > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to show toast notification
function showToast(message, type = 'success') {
    // Remove any existing toasts first
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ?
        '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
        '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

    toast.className = `toast-notification fixed top-24 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-all duration-300 max-w-sm`;
    toast.innerHTML = `
        <div class="flex items-center">
            ${icon}
            <span class="font-medium">${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);

    // Animate out and remove
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Function to animate cart icon - ENHANCED
function animateCartIcon() {
    const cartIcon = document.querySelector('#cart-link i[data-lucide="shopping-cart"]');
    const cartBadge = document.getElementById('cart-badge');
    const cartLink = document.querySelector('#cart-link');

    if (cartIcon) {
        // Animate cart icon with bounce effect
        cartIcon.style.transform = 'scale(1.3)';
        cartIcon.style.color = '#10b981';
        cartIcon.style.transition = 'all 0.3s ease';

        // Add success pulse to cart link
        cartLink.classList.add('success-pulse');

        // Animate badge if visible
        if (cartBadge && !cartBadge.classList.contains('hidden')) {
            cartBadge.classList.add('badge-bounce');
            cartBadge.style.backgroundColor = '#10b981';
        }

        setTimeout(() => {
            cartIcon.style.transform = 'scale(1)';
            cartIcon.style.color = '';
            cartLink.classList.remove('success-pulse');

            if (cartBadge && !cartBadge.classList.contains('hidden')) {
                cartBadge.classList.remove('badge-bounce');
                cartBadge.style.backgroundColor = '#ef4444';
            }
        }, 600);
    }
}
</script>
<?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/layout/header.blade.php ENDPATH**/ ?>