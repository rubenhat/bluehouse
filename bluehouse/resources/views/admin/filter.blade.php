@extends('admin.layout')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Penjualan</h1>
        <p class="text-gray-600">Analisa penjualan</p>
    </div>

    <!-- Filter Card -->
    {{-- <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <div class="flex items-center mb-4">
            <i class="fas fa-filter text-gray-500 mr-2"></i>
            <h2 class="text-lg font-semibold">Filter Periode</h2>
        </div>
         --}}
        {{--  <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date"
                       name="end_date"
                       value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>Reset
            </button>

            <a href="{{ route('admin.laporan.export', request()->all()) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>Export PDF
            </a>
        </form>
         --}}
        
    </div>

    
    <!-- Detail Transaksi -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-list text-gray-500 mr-2"></i>
                <h3 class="text-lg font-semibold">Detail Transaksi</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->order_id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $transaction->created_at->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $transaction->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $transaction->customer_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-500">{{ $transaction->customer_phone }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($transaction->status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($transaction->status === 'completed') bg-green-100 text-green-800
                                @elseif($transaction->status === 'cancelled') bg-red-100 text-red-800
                                @endif">
                                @if($transaction->status === 'pending') Pending
                                @elseif($transaction->status === 'confirmed') Dikonfirmasi
                                @elseif($transaction->status === 'completed') Selesai
                                @elseif($transaction->status === 'cancelled') Dibatalkan
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>Tidak ada transaksi ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>


@endsection
