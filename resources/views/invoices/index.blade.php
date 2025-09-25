@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Invoices</h1>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card mb-4 p-3 shadow-sm">
            <form method="GET" action="{{ route('invoices.index') }}" class="row g-3 align-items-end">
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
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
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
                        <th>Kode</th><th>Member</th><th>Periode</th><th>Jumlah</th><th>Status</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{ $inv->code }}</td>
                            <td>{{ $inv->member->user->name }}</td>
                            <td>{{ $inv->period->format('M Y') }}</td>
                            <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                            <td>{{ ucfirst($inv->status) }}</td>
                            <td><a href="{{ route('invoices.show',$inv) }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card shadow-lg mt-4" style="font-size: 1rem;">
            <div class="row mb-2 mt-4">
                <div class="col-md-2">
                    <div class="p-3 text-center">
                        <h6 class="text-muted mb-1">Total Data Invoices</h6>
                        <h4 class="fw-bold">{{ $invoices->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('invoices.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('invoices.export.excel', request()->all()) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
