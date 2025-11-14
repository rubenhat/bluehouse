@extends('layout.layout')

@section('title', 'Ringkasan')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ url()->previous() }}" class="text-2xl font-semibold">←</a>
        <span class="text-red-600 font-semibold">Tambah produk</span>
    </div>

    {{-- Cart List --}}
    @foreach ($cart as $item)
        <div class="mb-8">

            <div class="flex items-center justify-between">
                <span class="text-lg font-semibold">{{ $item['qty'] }}x {{ $item['name'] }}</span>
                <span class="text-lg font-semibold">{{ number_format($item['price'], 0, ',', '.') }}</span>
            </div>

            {{-- Note button --}}
            <form method="POST" action="{{ route('cart.note') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">

                <button type="button"
                        onclick="document.getElementById('note-{{ $item['id'] }}').classList.toggle('hidden')"
                        class="bg-red-500 text-white px-4 py-2 mt-2 rounded-lg inline-flex items-center gap-2 shadow">
                    📄 tambahkan catatan
                </button>

                <textarea id="note-{{ $item['id'] }}"
                          name="note"
                          class="hidden mt-2 w-full border rounded-lg p-3"
                          placeholder="Contoh: Pedas, jangan bawang...">{{ $item['note'] }}</textarea>

                <button class="hidden" id="submit-note-{{ $item['id'] }}"></button>
            </form>

            {{-- Quantity --}}
            <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-4 mt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">

                <button name="qty" value="{{ $item['qty'] - 1 }}"
                    class="border border-red-600 text-red-600 w-10 h-10 rounded-full text-xl flex items-center justify-center">
                    –
                </button>

                <span class="text-lg font-semibold">{{ $item['qty'] }}</span>

                <button name="qty" value="{{ $item['qty'] + 1 }}"
                    class="border border-red-600 text-red-600 w-10 h-10 rounded-full text-xl flex items-center justify-center">
                    +
                </button>
            </form>

        </div>
    @endforeach

    {{-- Summary --}}
    @php
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
        $pembulatan = 0;
        $total = $subtotal + $pembulatan;
    @endphp

    <div class="mt-6 space-y-1 text-lg">
        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between">
            <span>Pembulatan</span>
            <span>{{ number_format($pembulatan, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between font-bold mt-4">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Voucher --}}
    <div class="mt-10">
        <input type="text" placeholder="Masukkan Kode Promo Anda Disini"
               class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-4 text-gray-600">
    </div>

</div>

{{-- Footer --}}
<div class="fixed bottom-0 left-0 w-full bg-white p-6 border-t flex items-center justify-between">
    <div class="text-xl font-bold">
        Rp {{ number_format($total, 0, ',', '.') }}
    </div>
    <a href="{{ route('checkout.index') }}">
    <button class="bg-red-600 text-white px-8 py-3 rounded-xl text-lg font-bold w-full">
        Bayar
    </button>
</a>

</div>

@endsection
