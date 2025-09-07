<!DOCTYPE html>
<html>
<head>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:8px; text-align:left; }
        th { background:#f2f2f2; }
    </style>
</head>
<body>
    <h2>Daftar Cabang</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $branch)
            <tr>
                <td>{{ $branch->name }}</td>
                <td>{{ $branch->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
