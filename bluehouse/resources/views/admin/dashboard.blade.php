@extends('admin.layout')

@section('title', 'Dashboard - Manajemen Pesanan')

@section('content')
<div class="flex">
    
    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white shadow-md">
        <div class="p-5 border-b">
            <h1 class="text-lg font-semibold">Blue House Farm Admin</h1>
        </div>

        <nav class="p-4 space-y-2">
            <a href="#" class="flex items-center p-3 rounded-lg bg-blue-600 text-white">
                <span class="ml-2 font-medium">Dashboard</span>
            </a>

            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                <span class="ml-2 font-medium">Manajemen Pesanan</span>
            </a>

            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                <span class="ml-2 font-medium">Manajemen Menu</span>
            </a>

            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                <span class="ml-2 font-medium">Laporan Transaksi</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 bg-gray-50 min-h-screen">

        <h1 class="text-2xl font-semibold mb-1">Dashboard - Manajemen Pesanan</h1>
        <p class="text-gray-600 mb-6">Pantau dan kelola pesanan secara real-time</p>

        <!-- CARDS -->
        <div class="grid grid-cols-4 gap-5 mb-8">
            
            <!-- Pending -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Pesanan Pending</p>
                    <span>⚠️</span>
                </div>
                <h2 class="text-3xl font-bold">1</h2>
                <p class="text-sm text-gray-500">Menunggu konfirmasi</p>
            </div>

            <!-- Diproses -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Sedang Diproses</p>
                    <span>📦</span>
                </div>
                <h2 class="text-3xl font-bold">1</h2>
                <p class="text-sm text-gray-500">Dalam proses pembuatan</p>
            </div>

            <!-- Siap -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Siap Disajikan</p>
                    <span>✔️</span>
                </div>
                <h2 class="text-3xl font-bold text-green-600">1</h2>
                <p class="text-sm text-gray-500">Siap untuk customer</p>
            </div>

            <!-- Total Hari Ini -->
            <div class="border rounded-xl p-5 bg-white">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold text-gray-700">Total Hari Ini</p>
                    <span>🛒</span>
                </div>
                <h2 class="text-3xl font-bold">4</h2>
                <p class="text-sm text-gray-500">Rp 425.000</p>
            </div>

        </div>

        <!-- PESANAN AKTIF -->
        <div class="bg-white rounded-xl p-6 shadow-sm mb-8">
            <h2 class="text-lg font-semibold mb-4">Pesanan Aktif</h2>

            <!-- Pesanan 1 -->
            <div class="border rounded-xl p-5 mb-4">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">BHF-001 <span class="text-xs bg-gray-200 px-2 py-1 rounded">Pending</span></p>
                        <p class="text-sm text-gray-600">Budi Santoso</p>
                        <p class="text-xs text-gray-400">5 menit yang lalu</p>
                    </div>

                    <p class="font-semibold text-blue-600">Rp 115.000</p>
                </div>

                <button class="w-full mt-4 bg-blue-800 text-white py-2 rounded-lg hover:bg-blue-900">
                    Terima Pesanan
                </button>
            </div>

            <!-- Pesanan 2 -->
            <div class="border rounded-xl p-5 mb-4">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">BHF-002 <span class="text-xs bg-blue-200 px-2 py-1 rounded">Diproses</span></p>
                        <p class="text-sm text-gray-600">Siti Nurhaliza</p>
                        <p class="text-xs text-gray-400">15 menit yang lalu</p>
                    </div>

                    <p class="font-semibold text-blue-600">Rp 114.000</p>
                </div>

                <button class="w-full mt-4 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Tandai Siap
                </button>
            </div>

            <!-- Pesanan 3 -->
            <div class="border rounded-xl p-5">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">BHF-003 <span class="text-xs bg-green-200 px-2 py-1 rounded">Siap</span></p>
                        <p class="text-sm text-gray-600">Ahmad Fauzi</p>
                        <p class="text-xs text-gray-400">30 menit yang lalu</p>
                    </div>

                    <p class="font-semibold text-blue-600">Rp 168.000</p>
                </div>

                <button class="w-full mt-4 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Selesaikan
                </button>
            </div>

        </div>

        <!-- ITEM TERLARIS -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-6">Item Terlaris Hari Ini</h2>

            <div class="space-y-4">

                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full">1</div>
                        <div>
                            <p class="font-semibold">Blue House Signature Coffee</p>
                            <p class="text-xs text-gray-500">2 porsi terjual</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp 80.000</p>
                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">coffee</span>
                    </div>
                </div>

                <!-- Tambah item lainnya sesuai gambar -->
            </div>
        </div>

    </main>

</div>
@endsection
