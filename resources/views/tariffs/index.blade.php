@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Tarif</h1>
    <a href="{{ route('tariffs.create') }}" class="btn btn-primary mb-3">Tambah Tarif</a>

    <table class="table table-bordered">
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

    {{ $tariffs->links() }}
</div>
@endsection
