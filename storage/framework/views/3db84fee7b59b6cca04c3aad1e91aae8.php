<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md fixed h-full">
            <div class="p-5 border-b">
                <h1 class="text-lg font-semibold">Blue House Farm Admin</h1>
            </div>

            <nav class="p-4 space-y-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'); ?>">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="<?php echo e(route('admin.pesanan')); ?>" class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('admin.pesanan*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'); ?>">
                    <i class="fa-solid fa-clipboard-list w-5"></i>
                    <span class="ml-3 font-medium">Manajemen Pesanan</span>
                </a>

                <a href="<?php echo e(route('admin.menu')); ?>" class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('admin.menu*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'); ?>">
                    <i class="fa-solid fa-utensils w-5"></i>
                    <span class="ml-3 font-medium">Manajemen Menu</span>
                </a>

                <a href="<?php echo e(route('admin.laporan')); ?>" class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('admin.laporan*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'); ?>">
                    <i class="fa-solid fa-chart-bar w-5"></i>
                    <span class="ml-3 font-medium">Laporan Transaksi</span>
                </a>
            </nav>
        </aside>

        <!-- MAIN -->
        <main class="ml-64 w-full min-h-screen">

            <!-- Topbar -->
            <div class="flex justify-between items-center p-5 bg-white shadow-sm">
                <h2 class="text-xl font-semibold"><?php echo $__env->yieldContent('title'); ?></h2>

                <div class="flex items-center space-x-6 text-gray-700">

                    <button class="text-xl">
                        <i class="fa-regular fa-moon"></i>
                    </button>

                    <button class="text-xl">
                        <i class="fa-regular fa-bell"></i>
                    </button>

                    <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center hover:text-red-600 transition-colors">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="ml-2">Keluar</span>
                        </button>
                    </form>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-10">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

        </main>

    </div>

    <?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/layout.blade.php ENDPATH**/ ?>