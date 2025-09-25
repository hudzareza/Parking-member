<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Invoices</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Daftar Invoices</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Member</th>
                <th>Cabang</th>
                <th>Periode</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
                <th>Dibayar Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $inv)
                <tr>
                    <td>{{ $inv->code }}</td>
                    <td>{{ $inv->member->user->name ?? '-' }}</td>
                    <td>{{ $inv->branch->name ?? '-' }}</td>
                    <td>{{ $inv->period->format('F Y') }}</td>
                    <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                    <td>{{ ucfirst($inv->status) }}</td>
                    <td>{{ $inv->due_date?->format('d-m-Y') }}</td>
                    <td>{{ $inv->paid_at?->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
