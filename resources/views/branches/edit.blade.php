@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Cabang</h1>

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

    {{-- Form edit branch --}}
    <form action="{{ route('branches.update', $branch->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Cabang <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}" required
                   class="form-control">
        </div>

        {{-- Address --}}
        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea name="address" id="address" rows="3"
                      class="form-control">{{ old('address', $branch->address) }}</textarea>
        </div>
        <input type="hidden" name="code" value="{{ old('code', $branch->code) }}">
        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('branches.index') }}"
               class="btn btn-danger">
               Batal
            </a>
            <button type="submit"
                    class="btn btn-success">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
