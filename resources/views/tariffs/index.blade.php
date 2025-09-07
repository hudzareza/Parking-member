@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Tarif</h1>
        <a href="{{ route('tariffs.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i>Tambah Tarif
        </a>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Cabang</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tarif</th>
                        <th>Berlaku Mulai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tariffs as $tariff)
                    <tr>
                        <td>{{ $tariff->branch?->name ?? 'Global' }}</td>
                        <td>{{ ucfirst($tariff->vehicle_type) }}</td>
                        <td>Rp {{ number_format($tariff->amount_cents / 100, 0, ',', '.') }}</td>
                        <td>{{ $tariff->effective_start->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('tariffs.edit', $tariff) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('tariffs.destroy', $tariff) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus tarif ini?')">Hapus</button>
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
