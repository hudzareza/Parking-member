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
        <div class="card mb-4 p-3 shadow-sm">
            <form method="GET" action="{{ route('members.index') }}" class="row g-3 align-items-end">
                {{-- Filter Cabang --}}
                @role('super-admin|pusat')
                <div class="col-md-3">
                    <label class="form-label">Cabang</label>
                    <select name="branch_id" class="form-select">
                        <option value="">-- Semua Cabang --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endrole

                {{-- Filter Bulan --}}
                <div class="col-md-2">
                    <label class="form-label">Bulan</label>
                    <select name="month" class="form-select">
                        <option value="">-- Semua --</option>
                        @for ($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Tahun --}}
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <select name="year" class="form-select">
                        <option value="">-- Semua --</option>
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Range Tanggal --}}
                <div class="col-md-2">
                    <label class="form-label">Dari</label>
                    <input type="text" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Pilih tanggal">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai</label>
                    <input type="text" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="Pilih tanggal">
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>

        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Lokasi</th>
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
        <div class="card shadow-lg mt-4" style="font-size: 1rem;">
            <div class="row mb-2 mt-4">
                <div class="col-md-2">
                    <div class="p-3 text-center">
                        <h6 class="text-muted mb-1">Total Member</h6>
                        <h4 class="fw-bold">{{ $members->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('members.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('members.export.excel', request()->all()) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
