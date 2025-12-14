<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Blue House Farm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .period {
            font-size: 12px;
            color: #888;
        }

        .statistics {
            margin-bottom: 25px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .transactions {
            margin-top: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .currency {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Blue House Farm</h1>
        <h2>Laporan Transaksi</h2>
        <div class="period">
            Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}
        </div>
    </div>

    <!-- Statistics Summary -->
    <div class="statistics">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $totalPesanan }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Rata-rata Nilai Pesanan</div>
                <div class="stat-value">Rp {{ number_format($rataRataNilaiPesanan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Pesanan Dibatalkan</div>
                <div class="stat-value">{{ $pesananDibatalkan }}</div>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="transactions">
        <div class="section-title">Detail Transaksi</div>

        @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Pesanan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Nama Customer</th>
                    <th>No. Telepon</th>
                    <th class="currency">Total</th>
                    <th class="center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $index => $transaction)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $transaction->order_id }}</td>
                    <td>
                        {{ $transaction->created_at->format('d M Y') }}<br>
                        <small>{{ $transaction->created_at->format('H:i') }} WIB</small>
                    </td>
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->customer_phone }}</td>
                    <td class="currency">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    <td class="center">
                        <span class="status
                            @if($transaction->status === 'pending') status-pending
                            @elseif($transaction->status === 'confirmed') status-confirmed
                            @elseif($transaction->status === 'completed') status-completed
                            @elseif($transaction->status === 'cancelled') status-cancelled
                            @endif">
                            @if($transaction->status === 'pending') Pending
                            @elseif($transaction->status === 'confirmed') Dikonfirmasi
                            @elseif($transaction->status === 'completed') Selesai
                            @elseif($transaction->status === 'cancelled') Dibatalkan
                            @endif
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 30px; color: #666;">
            <p>Tidak ada transaksi ditemukan untuk periode yang dipilih.</p>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan digenerate pada {{ now()->format('d F Y H:i:s') }} WIB</p>
        <p>Blue House Farm - Sistem Manajemen Pesanan</p>
    </div>
</body>
</html>
