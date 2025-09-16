<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kendaraan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Kendaraan</h3>
    <table>
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Member</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $v)
                <tr>
                    <td>{{ $v->plate_number }}</td>
                    <td>{{ ucfirst($v->vehicle_type) }}</td>
                    <td>{{ optional($v->member->user)->name }}</td>
                    <td>{{ optional($v->member->branch)->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
