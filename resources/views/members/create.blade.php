@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Member</h1>

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

    {{-- Form tambah member --}}
    <form action="{{ route('members.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="form-control">
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="form-control">
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" id="password" required
                   class="form-control">
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="form-control">
        </div>

        {{-- Branch --}}
        <div class="mb-4">
            <label for="branch_id" class="block text-gray-700 text-sm font-bold mb-2">Lokasi <span class="text-red-500">*</span></label>
            <select name="branch_id" id="branch_id" required
                    class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Phone --}}
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Telepon <span class="text-red-500">*</span></label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                   class="form-control">
        </div>

        {{-- ID Card Number --}}
        <div class="mb-4">
            <label for="id_card_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor KTP <span class="text-red-500">*</span></label>
            <input type="text" name="id_card_number" id="id_card_number" value="{{ old('id_card_number') }}" required
                   class="form-control">
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('members.index') }}"
               class="btn btn-danger">
               Batal
            </a>
            <button type="submit"
                    class="btn btn-success">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
