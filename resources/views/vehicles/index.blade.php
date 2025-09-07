@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Kendaraan Member {{ $member->user->name }}</h1>
        <a href="{{ route('members.vehicles.create', $member) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>Tambah Kendaraan
        </a>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->plate_number }}</td>
                        <td>{{ ucfirst($vehicle->vehicle_type) }}</td>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>
                            <a href="{{ route('members.vehicles.show', [$member, $vehicle]) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('members.vehicles.edit', [$member, $vehicle]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('members.vehicles.destroy', [$member, $vehicle]) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kendaraan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
