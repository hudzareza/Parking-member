@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Detail Payment</h1>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <p><strong>Kode Payment:</strong> {{ $payment->code }}</p>
            <p><strong>Member:</strong> {{ $payment->member->user->name ?? '-' }}</p>
            <p><strong>Cabang:</strong> {{ $payment->branch->name ?? '-' }}</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($payment->gross_amount_cents/100,0,',','.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
            <p><strong>Dibayar pada:</strong> {{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}</p>
            <p><strong>Metode:</strong> {{ $payment->payment_type ?? '-' }}</p>
        </div>
    </div>

    <h3>Invoice yang Dibayar</h3>
    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->invoices as $inv)
                        <tr>
                            <td>{{ $inv->code }}</td>
                            <td>{{ $inv->period->format('F Y') }}</td>
                            <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                            <td>{{ ucfirst($inv->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
