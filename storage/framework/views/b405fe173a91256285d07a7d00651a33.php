<?php $__env->startSection('title', 'Menu Kami'); ?>

<?php $__env->startSection('content'); ?>

<!-- Main Container with top padding to avoid navbar overlap -->
<div class="min-h-screen bg-gray-50 pt-24 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex justify-between items-start mb-8">
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Menu Kami</h1>
                <p class="text-gray-600">Pilih dari berbagai menu pilihan kami yang segar dan berkualitas</p>
            </div>

            <!-- Admin Panel Button - Fixed positioning -->
            <div class="ml-4">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Admin Panel
                </a>
            </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="<?php echo e(route('menu.index')); ?>"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-all <?php echo e(!request('category') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm'); ?> border">
                    Semua
                </a>

                <a href="<?php echo e(route('menu.index', ['category' => 'bestseller'])); ?>"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-all <?php echo e(request('category') == 'bestseller' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm'); ?> border">
                    Best Seller
                </a>

                <?php if(isset($categories)): ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('menu.index', ['category' => $category->id])); ?>"
                       class="px-6 py-2 rounded-full text-sm font-medium transition-all <?php echo e(request('category') == $category->id ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm'); ?> border">
                        <?php echo e($category->name); ?>

                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Menu Grid -->
        <?php if(isset($menus) && $menus->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <!-- Image Container -->
                <div class="relative h-48 overflow-hidden">
                    <?php if($menu->image): ?>
                    <img src="<?php echo e(asset($menu->image)); ?>"
                         alt="<?php echo e($menu->name); ?>"
                         class="w-full h-full object-cover <?php echo e(!$menu->is_available ? 'grayscale' : ''); ?>">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <i class="fa-solid fa-image text-4xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Badges -->
                    <div class="absolute top-3 left-3 flex gap-2">
                        <?php if($loop->index < 4): ?>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            Best Seller
                        </span>
                        <?php endif; ?>

                        <?php if($menu->price < 30000): ?>
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            Promo
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <!-- Title -->
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-1"><?php echo e($menu->name); ?></h3>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2 h-10">
                        <?php echo e($menu->description ?: 'Nikmati kelezatan menu pilihan kami dengan cita rasa yang istimewa'); ?>

                    </p>

                    <!-- Price -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-blue-600 font-bold text-lg">
                                Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?>

                            </span>
                            <?php if($menu->price < 30000): ?>
                            <span class="text-gray-400 line-through text-sm ml-2">
                                Rp <?php echo e(number_format($menu->price * 1.3, 0, ',', '.')); ?>

                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Add to Cart Button - FORM SUBMISSION BIASA -->
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="w-full add-to-cart-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="menu_id" value="<?php echo e($menu->id); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium flex items-center justify-center gap-2 group add-to-cart-btn">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-600 mb-3">Menu tidak ditemukan</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">Belum ada menu untuk kategori ini. Silakan pilih kategori lain atau kembali ke semua menu.</p>
            <a href="<?php echo e(route('menu.index')); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Lihat semua menu
            </a>
        </div>
        <?php endif; ?>

        <!-- Load More Button (if needed) -->
        <?php if(isset($menus) && $menus->count() >= 8): ?>
        <div class="text-center mt-12">
            <button class="bg-gray-100 text-gray-700 px-8 py-3 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                Lihat Menu Lainnya
            </button>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .group:hover .group-hover\:scale-105 {
        transform: scale(1.05);
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    /* Loading state for buttons */
    .add-to-cart-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Smooth transitions */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Floating button animation */
    .floating-admin-btn {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-3px); }
    }

    /* Make sure navbar doesn't overlap content */
    body {
        padding-top: 0;
    }

    /* Override any default navbar positioning */
    .navbar-fixed {
        position: fixed !important;
        top: 0 !important;
        z-index: 1000 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Add loading state to buttons when clicked
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('.add-to-cart-btn');
            const originalText = button.querySelector('span').textContent;

            // Show loading state
            button.disabled = true;
            button.querySelector('span').textContent = 'Menambahkan...';
            button.classList.add('opacity-75');

            // Reset after 2 seconds (as fallback)
            setTimeout(() => {
                button.disabled = false;
                button.querySelector('span').textContent = originalText;
                button.classList.remove('opacity-75');
            }, 2000);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/menu/index.blade.php ENDPATH**/ ?>