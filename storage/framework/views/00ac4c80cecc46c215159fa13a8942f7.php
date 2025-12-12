<?php $__env->startSection('title', 'Checkout - Blue House Farm'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-24 pb-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                        ✓
                    </div>
                    <span class="ml-2 text-sm text-green-600 font-medium">Pilih Menu</span>
                </div>
                <div class="w-16 h-1 bg-gray-300">
                    <div class="w-full h-1 bg-green-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm text-blue-600 font-medium">Checkout</span>
                </div>
                <div class="w-16 h-1 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-sm font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm text-gray-500 font-medium">Selesai</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Ringkasan Pesanan
                </h3>

                <div class="space-y-4 mb-6">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <?php if($item->menu->image): ?>
                                <img src="<?php echo e(asset('storage/' . $item->menu->image)); ?>"
                                     alt="<?php echo e($item->menu->name); ?>"
                                     class="w-12 h-12 rounded-lg object-cover">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-300 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800"><?php echo e($item->menu->name); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo e($item->quantity); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-blue-600">
                                Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Show Notes if exists -->
                <?php if(request('notes')): ?>
                    <div class="border-t pt-4 mb-4">
                        <h4 class="font-medium text-gray-800 mb-2">Catatan Pesanan:</h4>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg"><?php echo e(request('notes')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center text-lg font-bold text-gray-800">
                        <span>Total</span>
                        <span class="text-blue-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Customer Information Form -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Pelanggan
                </h3>

                <form id="checkout-form" action="<?php echo e(route('checkout.store')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <!-- Hidden field untuk notes dari cart -->
                    <input type="hidden" name="notes" value="<?php echo e(request('notes')); ?>">

                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap
                        </label>
                        <input type="text"
                               id="customer_name"
                               name="customer_name"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan nama lengkap"
                               required>
                        <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor Telepon/WhatsApp
                        </label>
                        <input type="tel"
                               id="customer_phone"
                               name="customer_phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Contoh: 0812-3456-7890"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Kami akan menghubungi Anda melalui nomor ini untuk konfirmasi pesanan</p>
                        <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="visitors_count" class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah Pengunjung
                        </label>
                        <select id="visitors_count"
                                name="visitors_count"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">Pilih jumlah pengunjung</option>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?> <?php echo e($i === 1 ? 'orang' : 'orang'); ?></option>
                            <?php endfor; ?>
                            <option value="10+">Lebih dari 10 orang</option>
                        </select>
                        <?php $__errorArgs = ['visitors_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8">
                        <button type="submit"
                                id="checkout-btn"
                                class="w-full bg-blue-600 text-white py-4 rounded-xl hover:bg-blue-700 transition-all font-medium flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Konfirmasi Pesanan</span>
                        </button>

                        <a href="<?php echo e(route('cart.index')); ?>"
                           class="w-full mt-3 bg-gray-50 text-gray-600 py-3 rounded-xl hover:bg-gray-100 transition-all font-medium flex items-center justify-center space-x-2 border border-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>Kembali ke Keranjang</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation and submission
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('customer_phone').value.trim();
        const visitors = document.getElementById('visitors_count').value;

        if (!name) {
            e.preventDefault();
            alert('Nama lengkap harus diisi');
            document.getElementById('customer_name').focus();
            return false;
        }

        if (!phone) {
            e.preventDefault();
            alert('Nomor telepon harus diisi');
            document.getElementById('customer_phone').focus();
            return false;
        }

        if (!visitors) {
            e.preventDefault();
            alert('Jumlah pengunjung harus dipilih');
            document.getElementById('visitors_count').focus();
            return false;
        }

        // Phone validation (basic)
        const phoneRegex = /^[0-9\+\-\(\)\s]+$/;
        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            alert('Format nomor telepon tidak valid');
            document.getElementById('customer_phone').focus();
            return false;
        }

        // Show loading on button
        const submitBtn = document.getElementById('checkout-btn');
        if (submitBtn) {
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses Pesanan...
            `;
            submitBtn.disabled = true;
        }

        return true;
    });

    // Phone formatting
    const phoneInput = document.getElementById('customer_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length >= 4) {
                value = value.substring(0, 4) + '-' + value.substring(4);
            }
            if (value.length >= 9) {
                value = value.substring(0, 9) + '-' + value.substring(9, 13);
            }

            e.target.value = value;
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/checkout/index.blade.php ENDPATH**/ ?>