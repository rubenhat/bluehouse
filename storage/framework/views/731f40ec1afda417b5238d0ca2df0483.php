<?php $__env->startSection('title', 'Laporan Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-900">Laporan Transaksi</h1>
    <p class="text-sm text-gray-600">Filter dan export laporan transaksi</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
    <div class="flex items-center mb-3">
        <i class="fa-solid fa-calendar mr-2 text-gray-600"></i>
        <span class="text-sm font-medium text-gray-700">Filter Periode</span>
    </div>

    <form id="filterForm" method="GET" action="<?php echo e(route('admin.laporan')); ?>" class="space-y-3">
        <!-- Tanggal Mulai -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="date"
                   id="startDate"
                   name="start_date"
                   value="<?php echo e($startDate); ?>"
                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Tanggal Akhir -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Akhir</label>
            <input type="date"
                   id="endDate"
                   name="end_date"
                   value="<?php echo e($endDate); ?>"
                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Buttons -->
        <div class="flex gap-2 pt-2">
            <button type="submit" class="flex-1 px-3 py-2 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-filter mr-1"></i>Filter
            </button>
            <button id="resetButton" type="button" class="flex-1 px-3 py-2 text-xs border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                Reset
            </button>
            <button id="exportButton" type="button" class="flex-1 px-3 py-2 text-xs bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                <i class="fa-solid fa-download mr-1"></i>Export PDF
            </button>
        </div>
    </form>
</div>

<!-- Statistics Cards in 2x2 Grid -->
<div class="grid grid-cols-2 gap-4 mb-6">
    <!-- Total Pendapatan -->
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
        <p class="text-lg font-semibold text-gray-900">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
    </div>

    <!-- Total Pesanan -->
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <p class="text-xs text-gray-500 mb-1">Total Pesanan</p>
        <p class="text-lg font-semibold text-gray-900"><?php echo e($totalOrders); ?></p>
    </div>

    <!-- Rata-rata Nilai Pesanan -->
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <p class="text-xs text-gray-500 mb-1">Rata-rata Nilai Pesanan</p>
        <p class="text-lg font-semibold text-gray-900">Rp <?php echo e(number_format($averageOrderValue, 0, ',', '.')); ?></p>
    </div>

    <!-- Pesanan Selesai -->
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <p class="text-xs text-gray-500 mb-1">Pesanan Selesai</p>
        <p class="text-lg font-semibold text-gray-900"><?php echo e($completedOrders); ?></p>
    </div>
</div>

<!-- Transaction Details Table -->
<div class="bg-white rounded-lg shadow-sm border">
    <div class="p-4 border-b">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-list mr-2 text-gray-600"></i>
                <h3 class="text-sm font-medium text-gray-700">Detail Transaksi</h3>
            </div>
            <span class="text-xs text-gray-500">(<?php echo e($orders->count()); ?>)</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">No. Pesanan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Tanggal & Waktu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">No. Telepon</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs text-gray-900">
                            <?php echo e($order->order_id ?? 'BHF-' . str_pad($order->id, 3, '0', STR_PAD_LEFT)); ?>

                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d F Y \p\u\k\u\l H:i')); ?>

                        </td>
                        <td class="px-4 py-3 text-xs text-gray-900">
                            <?php echo e($order->customer_name ?? $order->name); ?>

                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <?php echo e($order->phone); ?>

                        </td>
                        <td class="px-4 py-3 text-xs font-medium text-gray-900">
                            Rp <?php echo e(number_format($order->total_amount ?? $order->total_price ?? 0, 0, ',', '.')); ?>

                        </td>
                        <td class="px-4 py-3">
                            <?php switch($order->status):
                                case ('pending'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-700">
                                        Pending
                                    </span>
                                    <?php break; ?>
                                <?php case ('diproses'): ?>
                                <?php case ('processing'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                        Diproses
                                    </span>
                                    <?php break; ?>
                                <?php case ('siap'): ?>
                                <?php case ('ready'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                        Siap
                                    </span>
                                    <?php break; ?>
                                <?php case ('selesai'): ?>
                                <?php case ('completed'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                    <?php break; ?>
                                <?php case ('dibatalkan'): ?>
                                <?php case ('cancelled'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                        Dibatalkan
                                    </span>
                                    <?php break; ?>
                                <?php default: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                            <?php endswitch; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-inbox text-gray-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-500 mb-1">Tidak ada transaksi</p>
                                <p class="text-xs text-gray-400">Pilih periode yang berbeda atau coba filter lain</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 text-center min-w-[200px]">
        <i class="fa-solid fa-spinner fa-spin text-xl text-blue-600 mb-3"></i>
        <p class="text-sm text-gray-700 font-medium">Generating PDF...</p>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Laporan page loaded successfully');

    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');

    dateInputs.forEach(input => {
        input.max = today;
    });

    // Reset Filter Button
    const resetButton = document.getElementById('resetButton');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            console.log('Reset button clicked');
            resetFilter();
        });
    }

    // Export PDF Button
    const exportButton = document.getElementById('exportButton');
    if (exportButton) {
        exportButton.addEventListener('click', function() {
            console.log('Export button clicked');
            exportPDF();
        });
    }
});

function resetFilter() {
    try {
        const today = new Date().toISOString().split('T')[0];
        const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];

        // Update form inputs
        document.getElementById('startDate').value = firstDay;
        document.getElementById('endDate').value = today;

        // Submit form
        document.getElementById('filterForm').submit();
    } catch (error) {
        console.error('Error in resetFilter:', error);
        alert('Terjadi kesalahan saat mereset filter');
    }
}

function exportPDF() {
    try {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            alert('Silakan pilih tanggal mulai dan tanggal akhir');
            return;
        }

        console.log('Exporting PDF with dates:', startDate, endDate);

        // Show loading
        showLoading();

        // Use Laravel route helper
        const exportUrl = '<?php echo e(route("admin.laporan.export-pdf")); ?>';
        const url = new URL(exportUrl, window.location.origin);
        url.searchParams.set('start_date', startDate);
        url.searchParams.set('end_date', endDate);

        console.log('Export URL:', url.toString());

        // Create hidden link and click it
        const link = document.createElement('a');
        link.href = url.toString();
        link.download = `laporan-transaksi-${startDate}-to-${endDate}.pdf`;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Hide loading after delay
        setTimeout(hideLoading, 2000);

    } catch (error) {
        console.error('Error in exportPDF:', error);
        hideLoading();
        alert('Terjadi kesalahan saat mengexport PDF: ' + error.message);
    }
}

function showLoading() {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function hideLoading() {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/laporan.blade.php ENDPATH**/ ?>