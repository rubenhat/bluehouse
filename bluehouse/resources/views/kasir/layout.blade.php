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

    <style>
        .nav-active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-white shadow-md fixed">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-lg font-semibold text-gray-800">Blue House Farm Kasir</h1>
            </div>

            <nav class="p-4 space-y-1">

                <a href="{{ route('kasir.pesanan.index') }}"
                   class="flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('kasir.pesanan.*') ? 'nav-active' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-receipt w-5"></i>
                    <span class="ml-3">Manajemen Pesanan</span>
                </a>

            </nav>
        </aside>

        <!-- MAIN -->
        <main class="ml-64 w-full min-h-screen">

            <!-- Topbar -->
            <div class="flex justify-between items-center p-6 bg-white shadow-sm border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>

                <div class="flex items-center space-x-6 text-gray-600">

                    <form action="{{ route('kasir.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center hover:text-gray-800 transition-colors bg-transparent border-none p-0">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ml-2">Keluar</span>
                        </button>
                    </form>


                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-6">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>
