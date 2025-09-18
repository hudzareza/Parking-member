<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Member - LOTUS Parking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #121212;
            color: #eaeaea;
        }
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .brand img {
            height: 50px;
            margin-right: 10px;
        }
        .brand-text {
            font-size: 1.8rem;
            font-weight: bold;
        }
        .brand-text .lotus {
            color: #FFD700; /* kuning emas */
        }
        .brand-text .parking {
            color: #fff;
        }
        .card {
            background: #1e1e1e;
            color: #ddd;
            border-radius: 12px;
            border: none;
        }
        .card h5 {
            color: #fff;
        }
        .table {
            background: #2a2a2a;
            color: #eaeaea;
        }
        .table th, .table td {
            color: #000 !important; /* teks menjadi hitam */
            vertical-align: middle;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            color: #000; /* agar input search/select tetap terbaca */
            background: #fff;
        }
    </style>
</head>
<body>
<div class="container mt-3">

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Pesan error umum --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

</div>

<div class="container py-4">

    <!-- Logo + Brand -->
    <div class="brand">
        <img src="{{ asset('img/logo.png') }}" alt="Lotus Parking Logo">
        <div class="brand-text">
            <span class="lotus">LOTUS</span> <span class="parking">Parking</span>
        </div>
    </div>

    <!-- Header Member -->
    <h1>Portal Member - {{ $member->user->name }}</h1>
    <p>Lokasi: {{ $member->branch->name }}</p>
    <p>No HP: {{ $member->phone }}</p>

    <h2 class="mt-4">Kendaraan & Tagihan</h2>

    @foreach($member->vehicles as $vehicle)
        <div class="card mb-4 p-3 shadow-sm">
            <h5>{{ ucfirst($vehicle->vehicle_type) }} - {{ $vehicle->plate_number }}</h5>

            <div class="table-responsive">
                <table class="table table-bordered datatable mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicle->invoices as $inv)
                            <tr>
                                <td>{{ $inv->code }}</td>
                                <td>{{ $inv->period->format('F Y') }}</td>
                                <td>Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</td>
                                <td>{{ ucfirst($inv->status) }}</td>
                                <td>{{ $inv->due_date->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada invoice untuk kendaraan ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    <hr>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->code }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->period)->format('F Y') }}</td>
            <td>Rp {{ number_format($invoice->amount_cents/100,0,',','.') }}</td>
            <td>
                @if($invoice->status === 'paid')
                    <span class="badge bg-success">Lunas</span>
                @else
                    <span class="badge bg-warning text-dark">{{ ucfirst($invoice->status) }}</span>
                @endif
            </td>
            <td>
                @if($invoice->proof_file)
                    <a href="{{ asset('storage/'.$invoice->proof_file) }}" target="_blank">Lihat Bukti</a>
                    <div>Status bukti: <strong>{{ $invoice->proof_status }}</strong></div>
                @endif

                @if($invoice->status !== 'paid')
                    <form action="{{ route('portal.invoices.uploadProof', $invoice->id) }}?token={{ $member->portal_token }}"
                        method="POST" 
                        enctype="multipart/form-data" 
                        class="mt-2">
                        @csrf
                        <input type="hidden" name="token" value="{{ $member->portal_token }}">
                        <div class="input-group">
                            <input type="file" name="proof_file" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.pdf" required>
                            <button class="btn btn-sm btn-success" type="submit">Upload Bukti</button>
                        </div>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach


    <h2>Pembayaran</h2>
    <p>Silakan transfer ke Virtual Account: <strong>{{ $virtualAccount }}</strong></p>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ entri",
            "emptyTable": "Belum ada data invoice"
        }
    });
});
</script>

</body>
</html>
