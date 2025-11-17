<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-100">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-white shadow-md fixed">
            <div class="p-6 border-b">
                <h1 class="text-lg font-semibold">Blue House Farm Admin</h1>
            </div>

            <nav class="p-4 space-y-2">

                <a href="/admin/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="/admin/orders" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-receipt"></i>
                    <span class="ml-3">Manajemen Pesanan</span>
                </a>

                <a href="/admin/menu" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-bars"></i>
                    <span class="ml-3">Manajemen Menu</span>
                </a>

                <a href="/admin/reports" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-file-lines"></i>
                    <span class="ml-3">Laporan Transaksi</span>
                </a>

            </nav>
        </aside>

        <!-- MAIN -->
        <main class="ml-64 w-full min-h-screen">

            <!-- Topbar -->
            <div class="flex justify-between items-center p-5 bg-white shadow-sm">
                <h2 class="text-xl font-semibold">@yield('title')</h2>

                <div class="flex items-center space-x-6 text-gray-700">

                    <button class="text-xl">
                        <i class="fa-regular fa-moon"></i>
                    </button>

                    <button class="text-xl">
                        <i class="fa-regular fa-bell"></i>
                    </button>

                    <a href="/logout" class="flex items-center">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="ml-2">Keluar</span>
                    </a>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-10">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>
