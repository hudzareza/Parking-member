@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Tambah Tarif</h1>

    {{-- Tampilkan error validation --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tambah tarif --}}
    <form action="{{ route('tariffs.store') }}" method="POST" >
        @csrf

        {{-- Branch --}}
        <div class="mb-4">
            <label for="branch_id" class="block text-gray-700 text-sm font-bold mb-2">Lokasi</label>
            <select name="branch_id" id="branch_id"
                    class="form-control">
                <option value="">-- Semua Lokasi --</option>
                @foreach($branches as $id => $name)
                    <option value="{{ $id }}" {{ old('branch_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Vehicle Type --}}
        <div class="mb-4">
            <label for="vehicle_type" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kendaraan <span class="text-red-500">*</span></label>
            <select name="vehicle_type" id="vehicle_type" required
                    class="form-control">
                <option value="">-- Pilih Jenis Kendaraan --</option>
                <option value="motor" {{ old('vehicle_type') == 'motor' ? 'selected' : '' }}>Motor</option>
                <option value="mobil" {{ old('vehicle_type') == 'mobil' ? 'selected' : '' }}>Mobil</option>
            </select>
        </div>

        {{-- Amount (dalam cents) --}}
        <div class="mb-4">
            <label for="amount_cents" class="block text-gray-700 text-sm font-bold mb-2">Tarif (dalam Rupiah) <span class="text-red-500">*</span></label>
            <input type="number" name="amount_cents" id="amount_cents" value="{{ old('amount_cents') }}" required
                   class="form-control" min="0">
        </div>

        {{-- Effective Start --}}
        <div class="mb-4">
            <label for="effective_start" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai Berlaku <span class="text-red-500">*</span></label>
            <input type="date" name="effective_start" id="effective_start" value="{{ old('effective_start') }}" required
                   class="form-control">
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('tariffs.index') }}"
               class="btn btn-danger">
               Batal
            </a>
            <button type="submit"
                    class="btn btn-success">
                Tambah Tarif
            </button>
        </div>
    </form>
</div>
@endsection
