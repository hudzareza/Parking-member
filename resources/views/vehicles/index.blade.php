@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kendaraan Member: {{ $member->user->name }}</h1>
    <a href="{{ route('members.vehicles.create', $member) }}" class="btn btn-primary mb-3">Tambah Kendaraan</a>

    <table class="table table-bordered">
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

    {{ $vehicles->links() }}
</div>
@endsection
