<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Member</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Daftar Member</h3>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>No KTP</th>
                <th>Cabang</th>
                <th>Tanggal Bergabung</th>
                <th>Kendaraan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $m)
                <tr>
                    <td>{{ $m->user->name }}</td>
                    <td>{{ $m->user->email }}</td>
                    <td>{{ $m->phone }}</td>
                    <td>{{ $m->id_card_number }}</td>
                    <td>{{ optional($m->branch)->name }}</td>
                    <td>{{ $m->joined_at->format('Y-m-d') }}</td>
                    <td>
                        @if($m->vehicles->count())
                            @foreach($m->vehicles as $v)
                                {{ $v->vehicle_type }} - {{ $v->plate_number }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
