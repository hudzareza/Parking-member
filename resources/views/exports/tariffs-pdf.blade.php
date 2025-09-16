<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Tarif</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Daftar Tarif Parkir</h3>
    <table>
        <thead>
            <tr>
                <th>Lokasi</th>
                <th>Jenis Kendaraan</th>
                <th>Tarif (Rp)</th>
                <th>Berlaku Mulai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tariffs as $t)
                <tr>
                    <td>{{ optional($t->branch)->name ?? 'Pusat' }}</td>
                    <td>{{ ucfirst($t->vehicle_type) }}</td>
                    <td>{{ number_format($t->amount_cents / 100, 2, ',', '.') }}</td>
                    <td>{{ $t->effective_start->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
