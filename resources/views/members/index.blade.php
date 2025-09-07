@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Member</h1>
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>Tambah Member
        </a>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{ $member->user->name }}</td>
                        <td>{{ $member->user->email }}</td>
                        <td>{{ $member->branch->name }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>
                            <a href="{{ route('members.vehicles.index', $member) }}" class="btn btn-sm btn-success">Data Kendaraan</a>
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-info">Detail Member</a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus member ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                    <h6 class="text-muted mb-1">Total Member</h6>
                    <h4 class="fw-bold">{{ $members->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
