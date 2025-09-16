@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Detail Invoice - {{ $invoice->code }}</h4>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <strong>Member:</strong> {{ $invoice->member->user->name ?? $invoice->member->name }} <br>
                <strong>Lokasi:</strong> {{ $invoice->branch->name ?? '-' }} <br>
                <strong>No HP:</strong> {{ $invoice->member->phone ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>Periode:</strong> {{ $invoice->period->format('F Y') ?? '-' }} <br>
                <strong>Jumlah:</strong> Rp {{ number_format($invoice->amount_cents / 100, 0, ',', '.') }} <br>
                <strong>Status:</strong> 
                @if($invoice->status === 'unpaid')
                    <span class="badge bg-danger">Belum Dibayar</span>
                @else
                    <span class="badge bg-success">Lunas</span>
                @endif
                <br>
                <strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d-m-Y') }}
            </div>

            @if($invoice->status === 'unpaid')
                <form action="{{ route('invoices.pay', $invoice->id) }}" method="GET">
                    <button type="submit" class="btn btn-success">
                        Konfirmasi bayar
                    </button>
                </form>
            @else
                <p class="text-success fw-bold mt-3">Invoice sudah dibayar.</p>
            @endif

        </div>
    </div>

</div>
@endsection
