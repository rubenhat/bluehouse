<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Blue House Farm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-700 to-blue-500">

    <div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center">Blue House Farm</h1>
        <p class="text-center text-gray-600 mb-6">Login Admin Panel</p>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
            <?php echo csrf_field(); ?>

            <label class="block mb-2 font-medium">Email</label>
            <input type="email" name="email" class="w-full mb-4 p-3 border rounded-lg bg-gray-100" 
                   placeholder="admin@bluehouse.com">

            <label class="block mb-2 font-medium">Password</label>
            <input type="password" name="password" class="w-full mb-4 p-3 border rounded-lg bg-gray-100"
                   placeholder="••••••••">

            <button class="w-full bg-blue-800 text-white p-3 rounded-lg font-semibold hover:bg-blue-900">
                Login
            </button>
        </form>

        <div class="mt-6 bg-gray-100 p-3 rounded-lg text-sm">
            <p class="font-semibold">Demo Login:</p>
            <p>Email: admin@bluehouse.com</p>
            <p>Password: admin123</p>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/login.blade.php ENDPATH**/ ?>