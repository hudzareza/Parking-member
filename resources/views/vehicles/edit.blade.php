@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Edit Kendaraan untuk {{ $member->user->name }}</h1>

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

    {{-- Form edit kendaraan --}}
    <form action="{{ route('members.vehicles.update', [$member, $vehicle]) }}" method="POST" >
        @csrf
        @method('PUT')

        {{-- Plate Number --}}
        <div class="mb-4">
            <label for="plate_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Polisi <span class="text-red-500">*</span></label>
            <input type="text" name="plate_number" id="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required
                   class="form-control" maxlength="20">
        </div>

        {{-- Vehicle Type --}}
        <div class="mb-4">
            <label for="vehicle_type" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kendaraan <span class="text-red-500">*</span></label>
            <select name="vehicle_type" id="vehicle_type" required
                    class="form-control">
                <option value="">-- Pilih Jenis Kendaraan --</option>
                <option value="motor" {{ old('vehicle_type', $vehicle->vehicle_type) == 'motor' ? 'selected' : '' }}>Motor</option>
                <option value="mobil" {{ old('vehicle_type', $vehicle->vehicle_type) == 'mobil' ? 'selected' : '' }}>Mobil</option>
            </select>
        </div>

        {{-- Brand --}}
        <div class="mb-4">
            <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}"
                   class="form-control" maxlength="100">
        </div>

        {{-- Model --}}
        <div class="mb-4">
            <label for="model" class="block text-gray-700 text-sm font-bold mb-2">Model</label>
            <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}"
                   class="form-control" maxlength="100">
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('members.vehicles.index', $member) }}"
               class="btn btn-danger">
               Batal
            </a>
            <button type="submit"
                    class="btn btn-success">
                Update Kendaraan
            </button>
        </div>
    </form>
</div>
@endsection
