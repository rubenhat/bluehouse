<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blue House Farm')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
    </style>
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body class="antialiased">

    @include('layout.header')

    <main>
        @yield('content')
    </main>

    @include('layout.footer')

    <script>
        lucide.createIcons();
    </script>

</body>
</html>