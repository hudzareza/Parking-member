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
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                    <h6 class="text-muted mb-1">Total Payment</h6>
                    <h4 class="fw-bold">{{ $payments->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
