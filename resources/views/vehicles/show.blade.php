@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Detail Kendaraan</h1>

    {{-- Informasi Member --}}
    <div class="bg-white shadow-md rounded px-6 py-4 mb-6">
        <h2 class="text-xl font-semibold mb-4">Member</h2>
        <p><strong>Nama:</strong> {{ $member->user->name }}</p>
        <p><strong>Email:</strong> {{ $member->user->email }}</p>
        <p><strong>Cabang:</strong> {{ $member->branch->name }}</p>
        <p><strong>Telepon:</strong> {{ $member->phone }}</p>
        <p><strong>Nomor KTP:</strong> {{ $member->id_card_number }}</p>
        <p><strong>Tanggal Bergabung:</strong> {{ \Carbon\Carbon::parse($member->joined_at)->format('Y-m-d') }}</p>
    </div>

    {{-- Informasi Kendaraan --}}
    <div class="bg-white shadow-md rounded px-6 py-4">
        <h2 class="text-xl font-semibold mb-4">Kendaraan</h2>
        <p><strong>Nomor Polisi:</strong> {{ $vehicle->plate_number }}</p>
        <p><strong>Jenis Kendaraan:</strong> {{ ucfirst($vehicle->vehicle_type) }}</p>
        <p><strong>Merk:</strong> {{ $vehicle->brand ?? '-' }}</p>
        <p><strong>Model:</strong> {{ $vehicle->model ?? '-' }}</p>
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('members.vehicles.index', $member) }}"
           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
           Kembali ke Daftar Kendaraan
        </a>
    </div>
</div>
@endsection
