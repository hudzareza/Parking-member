@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Manajemen User</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran/Role</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/user.png') }}" 
                                         alt="avatar" class="rounded-circle me-2" width="32" height="32">
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $user->roles->pluck('name')->implode(', ') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
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
                    <h6 class="text-muted mb-1">Total User</h6>
                    <h4 class="fw-bold">{{ $users->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




