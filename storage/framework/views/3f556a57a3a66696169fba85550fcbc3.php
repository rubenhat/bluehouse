<?php $__env->startSection('title', 'Pesanan Berhasil - Blue House Farm'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-24 pb-6">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Success Animation -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h1>
            <p class="text-gray-600">Terima kasih telah memesan di Blue House Farm</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Pesanan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Nomor Pesanan</p>
                    <p class="font-bold text-lg text-blue-600"><?php echo e($order->order_number); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                    <p class="font-semibold"><?php echo e($order->order_date->format('d M Y, H:i')); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Nama Pelanggan</p>
                    <p class="font-semibold"><?php echo e($order->customer_name); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jumlah Pengunjung</p>
                    <p class="font-semibold"><?php echo e($order->visitors_count); ?> orang</p>
                </div>
            </div>

            <div class="border-t pt-4">
                <h4 class="font-semibold text-gray-800 mb-3">Item Pesanan:</h4>
                <div class="space-y-3">
                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-medium"><?php echo e($item->menu->name); ?></span>
                            <span class="text-gray-600">x<?php echo e($item->quantity); ?></span>
                        </div>
                        <span class="font-semibold">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Total</span>
                        <span class="text-blue-600">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center space-y-4">
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="text-blue-800 font-medium mb-2">Langkah Selanjutnya:</p>
                <p class="text-blue-700 text-sm">Kami akan segera mengonfirmasi pesanan Anda melalui WhatsApp di nomor <strong><?php echo e($order->customer_phone); ?></strong></p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?php echo e(route('menu.index')); ?>"
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                    </svg>
                    Pesan Lagi
                </a>

                <a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $order->customer_phone)); ?>?text=Halo, saya ingin menanyakan pesanan dengan nomor <?php echo e($order->order_number); ?>"
                   target="_blank"
                   class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-2.462-.996-4.779-2.811-6.598-1.815-1.819-4.145-2.817-6.605-2.817-5.462 0-9.898 4.441-9.9 9.9-.001 1.76.438 3.497 1.271 5.013l.196.31-.809 2.956 3.018-.787.459.276z"/>
                        <path d="m8.149 6.374c-.269 0-.565-.010-.846.257-.24.23-.913.892-.913 2.176 0 1.284.935 2.525.935 2.525.108.124 1.476 2.251 3.577 3.15 1.694.725 2.107.58 2.488.54.381-.04 1.242-.508 1.418-.999.176-.49.176-.91.123-.99-.053-.08-.194-.125-.402-.22-.208-.095-.769-.301-1.002-.301-.15-.007-.29.058-.402.197-.197.195-.468.492-.468.492-.116.142-.378.055-.378.055-1.463-.518-2.632-2.323-2.632-2.323s-.202-.286-.034-.496c.135-.17.289-.353.433-.538.102-.127.215-.284.215-.284.108-.17.054-.316-.027-.433-.081-.117-.769-1.849-.769-1.849-.203-.507-.417-.514-.56-.514z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/checkout/success.blade.php ENDPATH**/ ?>