<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-24 pb-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm mb-4">
                <a href="<?php echo e(route('menu.index')); ?>" class="text-blue-600 hover:text-blue-700">Menu</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-600">Keranjang Belanja</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Keranjang Belanja</h1>
            <p class="text-gray-600">Review pesanan Anda sebelum melanjutkan ke pembayaran</p>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($cartItems->count() > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 9M7 13l-2.35-9.15"></path>
                                </svg>
                                Item Pesanan (<?php echo e($cartItems->count()); ?>)
                            </h2>
                        </div>

                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start space-x-4">
                                <!-- Product Image -->
                                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                                    <?php if($item->menu->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->menu->image)); ?>"
                                             alt="<?php echo e($item->menu->name); ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-800 mb-1"><?php echo e($item->menu->name); ?></h3>
                                            <p class="text-sm text-gray-600"><?php echo e($item->menu->description ?? 'Menu pilihan terbaik kami'); ?></p>
                                            <p class="text-blue-600 font-medium mt-1">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                        </div>

                                        <!-- Remove Button -->
                                        <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST" class="ml-4">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all"
                                                    onclick="return confirm('Hapus item dari keranjang?')"
                                                    title="Hapus item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Quantity and Total -->
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-600">Jumlah:</span>
                                            <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="flex items-center">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button type="button" onclick="decrementQuantity(<?php echo e($item->id); ?>)"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-l-lg transition-colors">-</button>
                                                    <input type="number"
                                                           id="quantity-<?php echo e($item->id); ?>"
                                                           name="quantity"
                                                           value="<?php echo e($item->quantity); ?>"
                                                           min="1"
                                                           max="99"
                                                           class="w-16 px-3 py-2 text-center border-0 focus:ring-0"
                                                           onchange="this.form.submit()">
                                                    <button type="button" onclick="incrementQuantity(<?php echo e($item->id); ?>)"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-r-lg transition-colors">+</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-800">
                                                Rp <?php echo e(number_format($item->quantity * $item->price, 0, ',', '.')); ?>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ringkasan Pesanan
                        </h2>

                        <!-- Order Summary Details -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal (<?php echo e($cartItems->sum('quantity')); ?> item)</span>
                                <span>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Layanan</span>
                                <span>Gratis</span>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-blue-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <form id="order-form" action="<?php echo e(route('checkout.index')); ?>" method="GET">
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan Pesanan (Opsional)
                                </label>
                                <textarea name="notes"
                                          id="notes"
                                          rows="3"
                                          placeholder="Contoh: Gula sedikit, tidak pakai es..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <!-- Checkout Button -->
                                <button type="submit"
                                        class="w-full bg-blue-600 text-white py-4 rounded-xl hover:bg-blue-700 transition-all font-medium flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>Lanjutkan ke Checkout</span>
                                </button>

                                <!-- Continue Shopping Button -->
                                <a href="<?php echo e(route('menu.index')); ?>"
                                   class="w-full bg-green-50 text-green-600 py-3 rounded-xl hover:bg-green-100 transition-all font-medium flex items-center justify-center space-x-2 border border-green-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span>Lanjut Belanja</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Empty Cart -->
            <div class="text-center py-20">
                <div class="w-40 h-40 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg">
                    <svg class="w-20 h-20 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 9M7 13l-2.35-9.15M15 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-700 mb-4">Keranjang Belanja Kosong</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Anda belum menambahkan item apapun ke keranjang. Mulai jelajahi menu kami dan temukan hidangan favorit Anda!
                </p>
                <div class="space-y-4">
                    <a href="<?php echo e(route('menu.index')); ?>"
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all transform hover:scale-105 shadow-lg font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Mulai Belanja Sekarang
                    </a>
                    <div class="text-sm text-gray-400">
                        atau <a href="<?php echo e(url('/')); ?>" class="text-blue-600 hover:text-blue-700">kembali ke beranda</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function incrementQuantity(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        const currentValue = parseInt(input.value);
        if (currentValue < 99) {
            input.value = currentValue + 1;
            input.form.submit();
        }
    }

    function decrementQuantity(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            input.form.submit();
        }
    }

    // Auto-save notes to localStorage
    const notesTextarea = document.getElementById('notes');
    if (notesTextarea) {
        // Load saved notes
        const savedNotes = localStorage.getItem('order_notes');
        if (savedNotes) {
            notesTextarea.value = savedNotes;
        }

        // Save notes on input
        notesTextarea.addEventListener('input', function() {
            localStorage.setItem('order_notes', this.value);
        });
    }

    // Clear notes when order is placed
    document.getElementById('order-form')?.addEventListener('submit', function() {
        localStorage.removeItem('order_notes');
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .transform:hover {
        transform: translateY(-2px) scale(1.02);
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .sticky {
        position: sticky;
        top: 6rem;
    }

    @media (max-width: 1024px) {
        .sticky {
            position: static;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/cart/index.blade.php ENDPATH**/ ?>