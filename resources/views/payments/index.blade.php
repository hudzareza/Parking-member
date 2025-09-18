@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Payments</h1>
    </div>
    <div class="card shadow-lg" style="font-size: 1rem;">
        <div class="card-body">
            <table id="users-table" class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Invoice</th><th>Jumlah</th><th>Status</th><th>Dibayar di</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $pay)
                        <tr>
                            <td>
                                @foreach($pay->invoices as $inv)
                                    <div>{{ $inv->code }}</div>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($pay->gross_amount_cents/100,0,',','.') }}</td>
                            <td>{{ ucfirst($pay->status) }}</td>
                            <td>{{ $pay->paid_at?->format('d M Y H:i') }}</td>
                            <td><a href="{{ route('payments.show',$pay) }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card shadow-lg mt-4" style="font-size: 1rem;">
            <div class="row mb-2 mt-4">
                <div class="col-md-2">
                    <div class="p-3 text-center">
                        <h6 class="text-muted mb-1">Total Data Payment</h6>
                        <h4 class="fw-bold">{{ $payments->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('payments.export.pdf') }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">
                    <div class="p-3 text-center">
                        <a href="{{ route('payments.export.excel') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
