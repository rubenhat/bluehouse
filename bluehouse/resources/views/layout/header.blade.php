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
            <a href="#" class="navbar-link text-gray-700 inline-flex items-center px-1 pt-1 text-base font-medium">
                Menu
            </a>
        </div>

        <!-- Ikon Aksi (Kanan) -->
        <div class="flex items-center space-x-6">
            <!-- Ikon Telepon/Pesan (Gelas Kopi) -->
            <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Pesan Antar">
                <i data-lucide="coffee" class="w-6 h-6"></i>
            </a>
            <!-- Ikon Keranjang Belanja -->
            <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-150 p-2 rounded-full hover:bg-gray-100" title="Keranjang Belanja">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </a>
            
            <!-- Tombol Mobile Menu -->
            <button type="button" class="sm:hidden text-gray-600 hover:text-blue-600 p-2 rounded-full hover:bg-gray-100" aria-controls="mobile-menu" aria-expanded="false">
                 <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </nav>
</header>
<!-- Script untuk inisialisasi ikon Lucide, perlu dipindahkan ke layout jika ingin berjalan di semua halaman -->
{{-- lucide.createIcons() akan dipanggil di layout.blade.php setelah body ditutup --}}