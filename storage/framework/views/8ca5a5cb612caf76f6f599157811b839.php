<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - Blue House Farm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #333;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .header h2 {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 11px;
        }
        .summary {
            margin-bottom: 30px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .summary-row {
            display: table-row;
        }
        .summary-card {
            display: table-cell;
            width: 25%;
            border: 1px solid #ddd;
            padding: 15px;
            vertical-align: top;
        }
        .summary-card h3 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 12px;
            font-weight: bold;
        }
        .summary-card .value {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 30px 0 15px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        .status {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status.diproses {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status.siap {
            background-color: #d4edda;
            color: #155724;
        }
        .status.selesai {
            background-color: #d4edda;
            color: #155724;
        }
        .status.dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Blue House Farm</h1>
        <h2>LAPORAN TRANSAKSI</h2>
        <p><strong>Periode:</strong> <?php echo e(\Carbon\Carbon::parse($startDate)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M Y')); ?></p>
        <p><strong>Dicetak pada:</strong> <?php echo e(\Carbon\Carbon::now()->format('d M Y H:i')); ?> WIB</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary">
        <div class="section-title">Ringkasan Laporan</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-card">
                    <h3>Total Pesanan</h3>
                    <div class="value"><?php echo e($totalOrders); ?></div>
                </div>
                <div class="summary-card">
                    <h3>Total Pendapatan</h3>
                    <div class="value">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></div>
                </div>
                <div class="summary-card">
                    <h3>Pesanan Selesai</h3>
                    <div class="value"><?php echo e($completedOrders); ?></div>
                </div>
                <div class="summary-card">
                    <h3>Pesanan Dibatalkan</h3>
                    <div class="value"><?php echo e($cancelledOrders); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="section-title">Detail Transaksi (<?php echo e($orders->count()); ?> transaksi)</div>

    <?php if($orders->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Tanggal & Waktu</th>
                <th>Customer</th>
                <th>No. Telepon</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($order->order_id ?? 'BHF-' . str_pad($order->id, 3, '0', STR_PAD_LEFT)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($order->customer_name ?? $order->name ?? '-'); ?></td>
                <td><?php echo e($order->phone ?? '-'); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->total_amount ?? $order->total_price ?? 0, 0, ',', '.')); ?></td>
                <td class="text-center">
                    <span class="status <?php echo e($order->status); ?>">
                        <?php echo e(ucfirst($order->status)); ?>

                    </span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="no-data">
        Tidak ada transaksi dalam periode yang dipilih.
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Blue House Farm - Sistem Manajemen Cafe</strong></p>
        <p>Laporan ini digenerate secara otomatis oleh sistem pada <?php echo e(\Carbon\Carbon::now()->format('d M Y H:i')); ?> WIB</p>
        <p>© <?php echo e(date('Y')); ?> Blue House Farm. All rights reserved.</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/reports/pdf.blade.php ENDPATH**/ ?>