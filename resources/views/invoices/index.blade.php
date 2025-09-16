@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Invoices</h1>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
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
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                    <h6 class="text-muted mb-1">Total Invoice</h6>
                    <h4 class="fw-bold">{{ $invoices->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
