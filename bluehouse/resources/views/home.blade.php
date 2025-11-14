@extends('layout.layout')

@section('title', 'Selamat Datang di Blue House Farm')

@section('content')
<section 
    class="relative flex items-center justify-start h-screen bg-cover bg-center text-white" 
     style="background-image: url('{{ asset('images/herobg.png') }}');"
>
    <!-- Overlay biru transparan -->
    <div class="absolute inset-0 bg-blue-900 bg-opacity-60"></div>

    <!-- Konten utama -->
    <div class="relative z-10 max-w-3xl px-8">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight drop-shadow-lg">
            Selamat Datang di Blue House Farm
        </h1>
        <p class="text-lg md:text-2xl mb-10 opacity-90 drop-shadow-md">
            Nikmati pengalaman kuliner terbaik dengan menu pilihan yang lezat dan suasana yang nyaman
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('menu.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition-transform transform hover:scale-105 inline-block">
                    Lihat Menu
            </a>
            <button class="bg-white text-blue-900 font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-transform transform hover:scale-105">
                Pesan Sekarang
            </button>
        </div>
    </div>
</section>
@endsection
