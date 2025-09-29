<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->code }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #444; margin-bottom: 20px; padding-bottom: 10px; }
        .header img { height: 50px; margin-bottom: 5px; }
        .header h1 { font-size: 20px; margin: 0; }
        .company { font-size: 12px; color: #555; }

        .invoice-title { text-align: center; font-size: 16px; font-weight: bold; margin: 20px 0; }

        .info { margin-bottom: 20px; }
        .info p { margin: 3px 0; }
        .bold { font-weight: bold; }

        .details { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details th, .details td { border: 1px solid #999; padding: 8px; text-align: left; font-size: 12px; }
        .details th { background-color: #f2f2f2; font-weight: bold; }

        .total { text-align: right; margin-top: 10px; font-size: 14px; }
        .total strong { font-size: 16px; }

        .status { margin-top: 15px; }
        .status span { padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .status .paid { background: #28a745; color: #fff; }
        .status .unpaid { background: #ffc107; color: #000; }

        .footer { text-align: center; font-size: 11px; margin-top: 30px; color: #777; border-top: 1px solid #ccc; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('img/logo-new.png') }}" alt="Lotus Parking Logo">
        <h1>LOTUS Parking</h1>
        <div class="company">Jl. Tanjung Duren Raya No. 27 A Kel : Tanjung Duren Utara Kec : Grogol Petamburan Jakarta Barat 11470 | Telp: (021) 565 5945 Whatsapp: 0852 8330 3970</div>
    </div>

    <div class="invoice-title">INVOICE</div>

    <div class="info">
        <p><span class="bold">Kode Invoice:</span> {{ $invoice->code }}</p>
        <p><span class="bold">Nama Member:</span> {{ $invoice->member->user->name }}</p>
        <p><span class="bold">Nomor HP:</span> {{ $invoice->member->phone }}</p>
        <p><span class="bold">Kendaraan:</span> {{ $invoice->vehicle->plate_number }}</p>
    </div>

    <table class="details">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Periode</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Biaya Parkir</td>
                <td>{{ $invoice->period->format('F Y') }}</td>
                <td>{{ $invoice->due_date->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($invoice->amount_cents/100,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Total Dibayar: <strong>Rp {{ number_format($invoice->amount_cents/100,0,',','.') }}</strong>
    </div>

    <div class="status">
        @if($invoice->status === 'paid')
            <span class="paid">LUNAS</span>
        @else
            <span class="unpaid">BELUM DIBAYAR</span>
        @endif
    </div>

    <div class="footer">
        Terima kasih sudah menggunakan layanan LOTUS Parking.<br>
        Invoice ini sah dan diterbitkan secara otomatis oleh sistem.
    </div>

</body>
</html>
