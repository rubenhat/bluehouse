@extends('layout.layout')

@section('title', 'Menu')

@section('content')

<div class="px-6 py-6">

    <h1 class="text-3xl font-bold mb-4">Menu</h1>

    {{-- Search bar --}}
    <div class="flex items-center gap-3">
        <div class="flex items-center w-full bg-white border border-gray-300 rounded-xl px-4 py-3">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg>
            <input type="text" placeholder="Pencarian"
                   class="w-full px-3 focus:outline-none" />
        </div>

        <button class="border border-gray-400 p-3 rounded-xl">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <h2 class="text-2xl font-semibold mt-8 mb-3">Combo</h2>

    <div class="space-y-6">

        @foreach ($menus as $m)
            <div class="flex items-center justify-between">

                <div class="flex items-center gap-4">

                    <img src="{{ asset($m->image) }}"
                         class="w-20 h-20 rounded-lg object-cover shadow" />

                    <div>
                        <h3 class="font-semibold text-lg">{{ $m->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $m->description }}</p>
                    </div>

                </div>

                <div class="text-lg font-bold">
                    {{ number_format($m->price, 0, ',', '.') }}
                </div>

            </div>
        @endforeach

    </div>

</div>

<button class="fixed bottom-5 left-5 bg-red-500 text-white p-4 rounded-full shadow-lg">
    <span class="font-bold">Menu</span>
</button>

@endsection
