@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Cabang</h1>

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

    {{-- Form tambah branch --}}
    <form action="{{ route('branches.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Cabang <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="form-control">
        </div>

        {{-- Address --}}
        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea name="address" id="address" rows="3"
                      class="form-control">{{ old('address') }}</textarea>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('branches.index') }}"
               class="btn btn-danger">
               Batal
            </a>
            <button type="submit" class="btn btn-success">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
