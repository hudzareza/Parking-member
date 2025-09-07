@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Daftar Cabang</h1>
        @can('manage branches')
            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>Tambah Cabang
            </a>
        @endcan
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
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
                                    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </a>
                                    <form action="{{ route('branches.destroy', $branch) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus cabang ini?')">
                                            <i class="bi bi-trash"></i>Hapus
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card shadow-lg mt-4" style="font-size: 1rem;">
        <div class="row mb-2 mt-4">
            <div class="col-md-2">
                <div class="p-3 text-center">
                    <h6 class="text-muted mb-1">Total Cabang</h6>
                    <h4 class="fw-bold">{{ $branches->count() }}</h4>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('branches.export.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('branches.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
