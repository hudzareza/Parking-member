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
    <div class="card shadow-lg mt-4" style="font-size: 1rem;">
        <div class="row mb-2 mt-4">
            <div class="col-md-2">
                <div class="p-3 text-center">
                    <h6 class="text-muted mb-1">Total Data Tarif</h6>
                    <h4 class="fw-bold">{{ $tariffs->count() }}</h4>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('tariffs.export.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('tariffs.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
