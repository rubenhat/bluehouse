@extends('layout.layout')

@section('title', 'Checkout')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">Data Customer</h2>

    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="font-semibold">Nama Lengkap</label>
            <input type="text" name="name" required
                   class="w-full border rounded-xl p-3 mt-1"
                   placeholder="Masukkan nama Anda">
        </div>

        <div>
            <label class="font-semibold">Nomor WhatsApp</label>
            <input type="text" name="phone" required
                   class="w-full border rounded-xl p-3 mt-1"
                   placeholder="Contoh: 08123456789">
        </div>

        <div>
            <label class="font-semibold">Email (Opsional)</label>
            <input type="email" name="email"
                   class="w-full border rounded-xl p-3 mt-1"
                   placeholder="Alamat email (opsional)">
        </div>

        <div>
            <label class="font-semibold">Jumlah Pengunjung</label>
            <input type="number" min="1" name="visitors" required
                   class="w-full border rounded-xl p-3 mt-1"
                   placeholder="Masukkan jumlah orang">
        </div>

        <button type="submit"
                class="w-full bg-red-600 text-white py-4 rounded-xl text-lg font-bold">
            Lanjutkan
        </button>
    </form>

</div>

@endsection
