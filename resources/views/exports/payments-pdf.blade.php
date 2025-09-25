<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Payments</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Invoice(s)</th>
                <th>Member</th>
                <th>Cabang</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tgl Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->code }}</td>
                    <td>{{ $p->invoices->pluck('code')->implode(', ') }}</td>
                    <td>{{ $p->member->user->name ?? '-' }}</td>
                    <td>{{ $p->branch->name ?? '-' }}</td>
                    <td>Rp {{ number_format($p->gross_amount_cents/100,0,',','.') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>{{ $p->paid_at?->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
