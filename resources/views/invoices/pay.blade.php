@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bayar Invoice {{ $invoice->code }}</h1>
    <p>Tagihan: Rp {{ number_format($invoice->amount_cents/100,0,',','.') }}</p>

    <button id="pay-button" class="btn btn-success">Bayar dengan Midtrans</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ location.href = "{{ route('invoices.show', $invoice) }}" },
            onPending: function(result){ console.log(result); },
            onError: function(result){ alert('Payment failed'); },
        });
    });
</script>
@endsection
