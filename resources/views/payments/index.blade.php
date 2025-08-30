@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payments</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Invoice</th><th>Amount</th><th>Status</th><th>Paid At</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $pay)
                <tr>
                    <td>{{ $pay->invoice->code }}</td>
                    <td>Rp {{ number_format($pay->amount_cents/100,0,',','.') }}</td>
                    <td>{{ ucfirst($pay->status) }}</td>
                    <td>{{ $pay->paid_at?->format('d M Y H:i') }}</td>
                    <td><a href="{{ route('payments.show',$pay) }}" class="btn btn-sm btn-primary">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $payments->links() }}
</div>
@endsection
