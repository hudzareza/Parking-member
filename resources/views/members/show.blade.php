@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Detail Member</h1>

    {{-- Info Member --}}
    <div class="bg-white shadow-md rounded px-6 py-4 mb-6">
        <h2 class="text-xl font-semibold mb-4">Informasi Pribadi</h2>
        <p><strong>Nama:</strong> {{ $member->user->name }}</p>
        <p><strong>Email:</strong> {{ $member->user->email }}</p>
        <p><strong>Cabang:</strong> {{ $member->branch->name }}</p>
        <p><strong>Telepon:</strong> {{ $member->phone }}</p>
        <p><strong>Nomor KTP:</strong> {{ $member->id_card_number }}</p>
        <p><strong>Tanggal Bergabung:</strong> {{ $member->joined_at->format('Y-m-d') }}</p>
    </div>

    {{-- Kendaraan Member --}}
    <div class="bg-white shadow-md rounded px-6 py-4">
        <h2 class="text-xl font-semibold mb-4">Kendaraan</h2>

        @if($member->vehicles->isEmpty())
            <p class="text-gray-600">Member ini belum memiliki kendaraan.</p>
        @else
            <table class="table-auto w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Plat Nomor</th>
                        <th class="px-4 py-2 border">Tipe</th>
                        <th class="px-4 py-2 border">Merk</th>
                        <th class="px-4 py-2 border">Model</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($member->vehicles as $vehicle)
                        <tr>
                            <td class="px-4 py-2 border">{{ $vehicle->plate_number }}</td>
                            <td class="px-4 py-2 border">{{ $vehicle->type }}</td>
                            <td class="px-4 py-2 border">{{ $vehicle->Brand }}</td>
                            <td class="px-4 py-2 border">{{ $vehicle->model }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('members.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
           Kembali
        </a>
    </div>
</div>
@endsection
