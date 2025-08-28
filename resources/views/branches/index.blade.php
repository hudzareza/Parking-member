@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Cabang</h1>

    @can('manage branches')
        <a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">Tambah Cabang</a>
    @endcan

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $branch)
                <tr>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->address }}</td>
                    <td>
                        @can('manage branches')
                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('branches.destroy', $branch) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus cabang ini?')">Hapus</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
