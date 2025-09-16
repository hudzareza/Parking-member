@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Daftar Kendaraan</h1>

    <form method="GET" action="{{ route('vehicles.listPerBranch') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="branch_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Lokasi --</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Jenis Kendaraan</th>
                        <th>Member</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $v)
                        <tr>
                            <td>{{ $v->plate_number }}</td>
                            <td>{{ $v->vehicle_type }}</td>
                            <td>{{ optional($v->member)->user->name }}</td>
                            <td>{{ optional($v->member->branch)->name }}</td>
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
                    <h6 class="text-muted mb-1">Total Data Kendaraan</h6>
                    <h4 class="fw-bold">{{ $vehicles->count() }}</h4>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('vehicles.export.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center">
                    <a href="{{ route('vehicles.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
