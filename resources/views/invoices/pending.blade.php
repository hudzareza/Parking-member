@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Bukti</h1>
    </div>
    <table  id="users-table" class="table table-bordered datatable">
        <thead>
            <tr>
                <th>Invoice</th><th>Member</th><th>Amount</th><th>Bukti</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $inv)
                <tr>
                    <td>{{ $inv->code }}<br>{{ \Carbon\Carbon::parse($inv->period)->format('F Y') }}</td>
                    <td>{{ $inv->member->user->name ?? $inv->member->user_id }}</td>
                    <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                    <td>
                        @if($inv->proof_file)
                            <a href="{{ asset('storage/'.$inv->proof_file) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.invoices.verify', $inv->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="note" value="Verified via admin panel">
                            <button class="btn btn-sm btn-success" onclick="return confirm('Terima dan tandai LUNAS?')">Terima</button>
                        </form>

                        <form action="{{ route('admin.invoices.reject', $inv->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="note" value="Bukti tidak sesuai">
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak bukti ini?')">Tolak</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
