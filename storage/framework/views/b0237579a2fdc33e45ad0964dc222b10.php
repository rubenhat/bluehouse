<?php $__env->startSection('title', 'Dashboard - Manajemen Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard - Manajemen Pesanan</h1>
    <p class="text-gray-600">Pantau dan kelola pesanan secara real-time</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pesanan Pending -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pesanan Pending</p>
                <p class="text-2xl font-bold text-orange-600"><?php echo e($pendingOrders ?? 0); ?></p>
                <p class="text-xs text-gray-500">Menunggu konfirmasi</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fa-regular fa-clock text-orange-600"></i>
            </div>
        </div>
    </div>

    <!-- Sedang Diproses -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Sedang Diproses</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($processedOrders ?? 0); ?></p>
                <p class="text-xs text-gray-500">Dalam proses pembuatan</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-spinner text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Siap Disajikan -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Siap Disajikan</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($readyOrders ?? 0); ?></p>
                <p class="text-xs text-gray-500">Siap untuk customer</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-check-circle text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Hari Ini -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Hari Ini</p>
                <p class="text-2xl font-bold text-purple-600"><?php echo e($totalOrdersToday ?? 0); ?></p>
                <p class="text-xs text-gray-500">Rp <?php echo e(number_format($todayRevenue ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-shopping-bag text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Pesanan Aktif -->
<div class="bg-white rounded-xl shadow-sm mb-8">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Pesanan Aktif</h2>
            <span class="text-sm text-gray-500"><?php echo e(isset($recentOrders) ? $recentOrders->count() : 0); ?> pesanan</span>
        </div>
    </div>

    <?php if(isset($recentOrders) && $recentOrders->count() > 0): ?>
    <div class="space-y-0">
        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="p-6 border-b last:border-b-0 hover:bg-gray-50 transition-colors">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-2">
                        <h3 class="font-semibold text-gray-900"><?php echo e($order->order_number ?? 'N/A'); ?></h3>
                        <?php if(isset($order->status)): ?>
                            <?php if($order->status == 'pending'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Pending
                                </span>
                            <?php elseif(in_array($order->status, ['confirmed', 'preparing'])): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Diproses
                                </span>
                            <?php elseif($order->status == 'ready'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Siap
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <p class="text-sm text-gray-600 mb-1"><?php echo e($order->customer_name ?? 'N/A'); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e(isset($order->created_at) ? $order->created_at->diffForHumans() : 'N/A'); ?></p>

                    <!-- Order Items -->
                    <div class="mt-3">
                        <?php if(isset($order->orderItems) && $order->orderItems->count() > 0): ?>
                            <?php $__currentLoopData = $order->orderItems->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-sm text-gray-600">
                                <?php echo e($item->quantity ?? 0); ?>x <?php echo e(isset($item->menu) ? $item->menu->name : 'Menu Terhapus'); ?>

                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($order->orderItems->count() > 2): ?>
                            <div class="text-xs text-gray-400">
                                +<?php echo e($order->orderItems->count() - 2); ?> item lainnya
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-sm text-gray-400">Tidak ada item</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="text-right">
                    <p class="font-semibold text-gray-900">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e(isset($order->orderItems) ? $order->orderItems->sum('quantity') : 0); ?> item</p>

                    <div class="flex gap-2 mt-3">
                        <?php if(isset($order->status)): ?>
                            <?php if($order->status == 'pending'): ?>
                                <button class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700"
                                        onclick="updateOrderStatus(<?php echo e($order->id); ?>, 'confirmed')">
                                    Terima
                                </button>
                                <button class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700"
                                        onclick="updateOrderStatus(<?php echo e($order->id); ?>, 'cancelled')">
                                    ✕
                                </button>
                            <?php elseif(in_array($order->status, ['confirmed', 'preparing'])): ?>
                                <button class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700"
                                        onclick="updateOrderStatus(<?php echo e($order->id); ?>, 'ready')">
                                    Siap
                                </button>
                            <?php elseif($order->status == 'ready'): ?>
                                <button class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700"
                                        onclick="updateOrderStatus(<?php echo e($order->id); ?>, 'completed')">
                                    Selesai
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.orders')); ?>" class="px-3 py-1 text-xs border border-gray-300 rounded hover:bg-gray-50">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="p-12 text-center text-gray-500">
        <i class="fa-solid fa-shopping-bag text-4xl mb-4 text-gray-300"></i>
        <p>Tidak ada pesanan aktif saat ini</p>
    </div>
    <?php endif; ?>
</div>

<!-- Item Terlaris Hari Ini -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Item Terlaris Hari Ini</h2>
    </div>

    <?php if(isset($topSellingToday) && $topSellingToday->count() > 0): ?>
    <div class="p-6">
        <div class="space-y-4">
            <?php $__currentLoopData = $topSellingToday; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-sm mr-3">
                        <?php echo e($index + 1); ?>

                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900"><?php echo e($item->name ?? 'N/A'); ?></h4>
                        <p class="text-sm text-gray-500"><?php echo e($item->total_sold ?? 0); ?> porsi terjual</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-900">Rp <?php echo e(number_format($item->total_revenue ?? 0, 0, ',', '.')); ?></p>
                    <p class="text-sm text-gray-500">Rp <?php echo e(number_format($item->price ?? 0, 0, ',', '.')); ?>/porsi</p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="p-12 text-center text-gray-500">
        <i class="fa-solid fa-chart-bar text-4xl mb-4 text-gray-300"></i>
        <p>Belum ada penjualan hari ini</p>
    </div>
    <?php endif; ?>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (confirm('Apakah Anda yakin ingin mengubah status pesanan?')) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>