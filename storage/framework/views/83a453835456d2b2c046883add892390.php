<?php $__env->startSection('title', 'Manajemen Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Pesanan</h1>
    <p class="text-gray-600">Kelola dan pantau semua pesanan</p>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-sm mb-6">
    <div class="flex border-b overflow-x-auto">
        <a href="<?php echo e(route('admin.orders')); ?>?status=all"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? 'all') == 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Semua
            <?php if(isset($statusCounts['all']) && $statusCounts['all'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-gray-100 rounded-full"><?php echo e($statusCounts['all']); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.orders')); ?>?status=pending"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? '') == 'pending' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Pending
            <?php if(isset($statusCounts['pending']) && $statusCounts['pending'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-orange-100 text-orange-600 rounded-full"><?php echo e($statusCounts['pending']); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.orders')); ?>?status=confirmed"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? '') == 'confirmed' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Dikonfirmasi
            <?php if(isset($statusCounts['confirmed']) && $statusCounts['confirmed'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded-full"><?php echo e($statusCounts['confirmed']); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.orders')); ?>?status=ready"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? '') == 'ready' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Siap
            <?php if(isset($statusCounts['ready']) && $statusCounts['ready'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full"><?php echo e($statusCounts['ready']); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.orders')); ?>?status=completed"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? '') == 'completed' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Selesai
            <?php if(isset($statusCounts['completed']) && $statusCounts['completed'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-gray-100 rounded-full"><?php echo e($statusCounts['completed']); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.orders')); ?>?status=cancelled"
           class="px-4 py-3 text-sm font-medium whitespace-nowrap <?php echo e(($status ?? '') == 'cancelled' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600 hover:text-gray-800'); ?>">
            Dibatalkan
            <?php if(isset($statusCounts['cancelled']) && $statusCounts['cancelled'] > 0): ?>
                <span class="ml-1 px-2 py-1 text-xs bg-red-100 text-red-600 rounded-full"><?php echo e($statusCounts['cancelled']); ?></span>
            <?php endif; ?>
        </a>
    </div>
</div>

<!-- Orders Content -->
<?php if(isset($orders) && $orders->count() > 0): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
        <!-- Order Header -->
        <div class="p-4 border-b border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-semibold text-gray-900"><?php echo e($order->order_number ?? 'N/A'); ?></h3>
                <?php if(($order->status ?? '') == 'pending'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        Pending
                    </span>
                <?php elseif(($order->status ?? '') == 'confirmed'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Dikonfirmasi
                    </span>
                <?php elseif(($order->status ?? '') == 'preparing'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Dipersiapkan
                    </span>
                <?php elseif(($order->status ?? '') == 'ready'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Siap
                    </span>
                <?php elseif(($order->status ?? '') == 'completed'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Selesai
                    </span>
                <?php elseif(($order->status ?? '') == 'cancelled'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Dibatalkan
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-sm text-gray-600"><?php echo e($order->customer_name ?? 'N/A'); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($order->customer_phone ?? 'N/A'); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($order->created_at ? $order->created_at->diffForHumans() : 'N/A'); ?></p>

            <!-- Indikator catatan -->
            <?php if($order->notes): ?>
            <div class="mt-2">
                <span class="inline-flex items-center px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                    <i class="fa-solid fa-sticky-note mr-1"></i>
                    Ada Catatan
                </span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Order Items -->
        <div class="p-4 border-b border-gray-100">
            <?php if(isset($order->orderItems) && $order->orderItems->count() > 0): ?>
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex justify-between items-center mb-2 last:mb-0">
                    <div class="flex-1">
                        <span class="text-sm font-medium text-gray-900"><?php echo e($item->quantity ?? 0); ?>x <?php echo e($item->menu->name ?? 'Menu Terhapus'); ?></span>
                    </div>
                    <span class="text-sm text-gray-900">Rp <?php echo e(number_format(($item->quantity * $item->price) ?? 0, 0, ',', '.')); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p class="text-sm text-gray-500">Tidak ada item</p>
            <?php endif; ?>

            <div class="pt-2 mt-2 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Total</span>
                    <span class="font-semibold text-gray-900">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></span>
                </div>
                <p class="text-xs text-gray-500 mt-1"><?php echo e($order->orderItems ? $order->orderItems->sum('quantity') : 0); ?> item</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-4">
            <div class="flex gap-2 mb-3">
                <?php if(($order->status ?? '') == 'pending'): ?>
                    <button onclick="updateOrderStatus('<?php echo e($order->id); ?>', 'confirmed')"
                            class="flex-1 px-3 py-2 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        Terima
                    </button>
                    <button onclick="updateOrderStatus('<?php echo e($order->id); ?>', 'cancelled')"
                            class="px-3 py-2 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                        ✕
                    </button>
                <?php elseif(($order->status ?? '') == 'confirmed'): ?>
                    <button onclick="updateOrderStatus('<?php echo e($order->id); ?>', 'preparing')"
                            class="flex-1 px-3 py-2 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        Proses
                    </button>
                <?php elseif(($order->status ?? '') == 'preparing'): ?>
                    <button onclick="updateOrderStatus('<?php echo e($order->id); ?>', 'ready')"
                            class="flex-1 px-3 py-2 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                        Siap
                    </button>
                <?php elseif(($order->status ?? '') == 'ready'): ?>
                    <button onclick="updateOrderStatus('<?php echo e($order->id); ?>', 'completed')"
                            class="flex-1 px-3 py-2 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                        Selesai
                    </button>
                <?php endif; ?>
            </div>

            <button onclick="showOrderDetail('<?php echo e($order->id); ?>')"
                    class="w-full px-3 py-2 text-xs border border-gray-300 rounded hover:bg-gray-50 transition-colors text-center">
                Detail
            </button>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Pagination -->
<?php if($orders->hasPages()): ?>
<div class="mt-8">
    <?php echo e($orders->appends(request()->query())->links()); ?>

</div>
<?php endif; ?>

<?php else: ?>
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <i class="fa-solid fa-shopping-bag text-4xl text-gray-300 mb-4"></i>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada pesanan</h3>
    <p class="text-gray-500">
        <?php if(($status ?? 'all') == 'all'): ?>
            Belum ada pesanan yang masuk.
        <?php else: ?>
            Tidak ada pesanan dengan status "<?php echo e($status ?? ''); ?>".
        <?php endif; ?>
    </p>
</div>
<?php endif; ?>

<!-- Modal Detail Pesanan -->
<div id="orderDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900" id="modalOrderTitle">Detail Pesanan</h3>
                <button onclick="closeOrderDetail()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="orderDetailContent">
                <div class="flex justify-center items-center py-12">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400"></i>
                    <span class="ml-3 text-gray-600">Memuat detail pesanan...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Show order detail modal
function showOrderDetail(orderId) {
    console.log('=== DEBUGGING ORDER DETAIL REQUEST ===');
    console.log('Order ID:', orderId);
    console.log('Order ID type:', typeof orderId);

    // Validate orderId
    if (!orderId || orderId === 'undefined' || orderId === 'null') {
        console.error('Invalid order ID:', orderId);
        alert('ID pesanan tidak valid');
        return;
    }

    document.getElementById('orderDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Reset content
    document.getElementById('orderDetailContent').innerHTML = `
        <div class="flex justify-center items-center py-12">
            <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400"></i>
            <span class="ml-3 text-gray-600">Memuat detail pesanan...</span>
        </div>
    `;

    // Test URL first
    const url = `/admin/orders/${orderId}`;
    console.log('Fetching URL:', url);
    console.log('Current base URL:', window.location.origin);
    console.log('Full URL:', window.location.origin + url);

    // Check if CSRF token exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found in meta tag');
    } else {
        console.log('CSRF token found:', csrfToken.getAttribute('content').substring(0, 10) + '...');
    }

    // Fetch order detail
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
        }
    })
    .then(response => {
        console.log('=== RESPONSE DETAILS ===');
        console.log('Response status:', response.status);
        console.log('Response statusText:', response.statusText);
        console.log('Response URL:', response.url);
        console.log('Response headers:', [...response.headers.entries()]);

        if (!response.ok) {
            // Get response text to see actual error
            return response.text().then(text => {
                console.error('=== ERROR RESPONSE BODY ===');
                console.error(text);

                // Try to parse as JSON first
                try {
                    const jsonData = JSON.parse(text);
                    throw new Error(`HTTP ${response.status}: ${jsonData.message || response.statusText}`);
                } catch (parseError) {
                    // If not JSON, show as text
                    throw new Error(`HTTP ${response.status}: ${response.statusText}\n\nResponse: ${text.substring(0, 500)}`);
                }
            });
        }

        return response.json();
    })
    .then(data => {
        console.log('=== ORDER DATA RECEIVED ===');
        console.log('Full response:', data);
        console.log('Success:', data.success);
        console.log('Order object:', data.order);

        if (data.success && data.order) {
            document.getElementById('modalOrderTitle').textContent = `Detail Pesanan - ${data.order.order_number}`;
            document.getElementById('orderDetailContent').innerHTML = renderOrderDetail(data.order);
        } else {
            console.error('API returned success=false or no order data:', data);
            document.getElementById('orderDetailContent').innerHTML = `
                <div class="text-center py-12">
                    <i class="fa-solid fa-exclamation-triangle text-3xl text-red-400 mb-4"></i>
                    <p class="text-red-600">Gagal memuat detail pesanan</p>
                    <p class="text-sm text-gray-500">${data.message || 'Unknown error'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('=== FETCH ERROR ===');
        console.error('Error object:', error);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);

        document.getElementById('orderDetailContent').innerHTML = `
            <div class="text-center py-12">
                <i class="fa-solid fa-exclamation-triangle text-3xl text-red-400 mb-4"></i>
                <p class="text-red-600">Terjadi kesalahan: ${error.message}</p>
                <div class="mt-4 p-4 bg-gray-100 rounded text-left text-xs">
                    <strong>Debug Info:</strong><br>
                    URL: ${url}<br>
                    Error: ${error.message}
                </div>
            </div>
        `;
    });
}

// Render order detail HTML
function renderOrderDetail(order) {
    console.log('=== RENDERING ORDER DETAIL ===');
    console.log('Order object:', order);
    console.log('Notes field:', order.notes);

    const formatCurrency = (amount) => new Intl.NumberFormat('id-ID').format(amount);
    const formatDate = (dateString) => new Date(dateString).toLocaleString('id-ID');

    let statusBadge = '';
    let actionButtons = '';

    // Status badge
    switch(order.status) {
        case 'pending':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800"><i class="fa-regular fa-clock mr-2"></i>Pending</span>';
            actionButtons = `
                <button onclick="updateOrderStatusFromModal('${order.id}', 'confirmed')" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm mb-3">
                    <i class="fa-solid fa-check mr-2"></i>Terima Pesanan
                </button>
                <button onclick="updateOrderStatusFromModal('${order.id}', 'cancelled')" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                    <i class="fa-solid fa-times mr-2"></i>Tolak Pesanan
                </button>
            `;
            break;
        case 'confirmed':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"><i class="fa-solid fa-check mr-2"></i>Dikonfirmasi</span>';
            actionButtons = `<button onclick="updateOrderStatusFromModal('${order.id}', 'preparing')" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm"><i class="fa-solid fa-spinner mr-2"></i>Mulai Proses</button>`;
            break;
        case 'preparing':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"><i class="fa-solid fa-spinner mr-2"></i>Dipersiapkan</span>';
            actionButtons = `<button onclick="updateOrderStatusFromModal('${order.id}', 'ready')" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"><i class="fa-solid fa-check-circle mr-2"></i>Tandai Siap</button>`;
            break;
        case 'ready':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><i class="fa-solid fa-check-circle mr-2"></i>Siap</span>';
            actionButtons = `<button onclick="updateOrderStatusFromModal('${order.id}', 'completed')" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"><i class="fa-solid fa-check-double mr-2"></i>Selesaikan</button>`;
            break;
        case 'completed':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><i class="fa-solid fa-check-double mr-2"></i>Selesai</span>';
            break;
        case 'cancelled':
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"><i class="fa-solid fa-times mr-2"></i>Dibatalkan</span>';
            break;
    }

    // Order items
    let itemsHtml = '';
    const orderItems = order.order_items || [];

    if (orderItems && orderItems.length > 0) {
        orderItems.forEach(item => {
            const menuName = (item.menu && item.menu.name) ? item.menu.name : 'Menu Terhapus';
            itemsHtml += `
                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-utensils text-gray-400 text-sm"></i>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-900 text-sm">${menuName}</h5>
                            <p class="text-xs text-gray-500">${item.quantity}x Rp ${formatCurrency(item.price)}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 text-sm">Rp ${formatCurrency(item.total)}</p>
                    </div>
                </div>
            `;
        });
    } else {
        itemsHtml = '<p class="text-gray-500 text-center py-4">Tidak ada item pesanan</p>';
    }

    // Notes section
    let notesHtml = '';
    if (order.notes && order.notes.trim() !== '') {
        console.log('Creating notes HTML with content:', order.notes);
        notesHtml = `
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <h4 class="text-base font-semibold text-yellow-800 mb-3 flex items-center">
                    <i class="fa-solid fa-sticky-note mr-2"></i>
                    Catatan Pesanan
                </h4>
                <div class="bg-white rounded-lg p-4 border border-yellow-200">
                    <p class="text-gray-700 text-sm whitespace-pre-line">${order.notes}</p>
                </div>
            </div>
        `;
    }

    return `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Pesanan -->
            <div class="space-y-6">
                <!-- Status dan Info Dasar -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Pesanan</h3>
                        ${statusBadge}
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nomor Pesanan</label>
                            <p class="text-base font-semibold text-gray-900">${order.order_number || 'N/A'}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Pesanan</label>
                            <p class="text-base text-gray-900">${formatDate(order.created_at)}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Customer</label>
                            <p class="text-base text-gray-900">${order.customer_name || 'N/A'}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                            <p class="text-base text-gray-900">${order.customer_phone || 'N/A'}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jumlah Pengunjung</label>
                            <p class="text-base text-gray-900">${order.visitors_count || 'N/A'} orang</p>
                        </div>
                    </div>
                </div>
                ${notesHtml}
            </div>

            <!-- Item Pesanan & Aksi -->
            <div class="space-y-6">
                <!-- Item Pesanan -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-base font-semibold text-gray-800 mb-4">Item Pesanan</h4>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        ${itemsHtml}
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Pesanan:</span>
                            <span class="text-lg font-bold text-blue-600">Rp ${formatCurrency(order.total_amount || 0)}</span>
                        </div>
                    </div>
                </div>

                <!-- Aksi Status -->
                ${actionButtons ? `
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-base font-semibold text-gray-800 mb-4">Aksi Pesanan</h4>
                    <div class="space-y-3">
                        ${actionButtons}
                    </div>
                </div>
                ` : ''}
            </div>
        </div>
    `;
}

// Close order detail modal
function closeOrderDetail() {
    document.getElementById('orderDetailModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('orderDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderDetail();
    }
});

// Update order status from card
function updateOrderStatus(orderId, status) {
    if (status === 'cancelled' && !confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        return;
    }

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
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pesanan');
    });
}

// Update order status from modal
function updateOrderStatusFromModal(orderId, status) {
    let confirmMessage = 'Apakah Anda yakin ingin mengubah status pesanan?';

    if (status === 'cancelled') {
        confirmMessage = 'Apakah Anda yakin ingin membatalkan pesanan ini?';
    }

    if (!confirm(confirmMessage)) {
        return;
    }

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
            closeOrderDetail();
            location.reload();
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pesanan');
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/pesanan.blade.php ENDPATH**/ ?>