@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Invoices</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Code</th><th>Member</th><th>Period</th><th>Amount</th><th>Status</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $inv)
                <tr>
                    <td>{{ $inv->code }}</td>
                    <td>{{ $inv->member->name }}</td>
                    <td>{{ $inv->period->format('M Y') }}</td>
                    <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                    <td>{{ ucfirst($inv->status) }}</td>
                    <td><a href="{{ route('invoices.show',$inv) }}" class="btn btn-sm btn-primary">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $invoices->links() }}
</div>
@endsection
