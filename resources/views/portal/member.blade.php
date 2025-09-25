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
        .invoice-card {
            border-left: 5px solid #4e73df;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .invoice-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
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
    <div class="mb-3">
        <a href="{{ route('portal.form') }}" class="btn btn-secondary">
            ⬅️ Kembali 
        </a>
    </div>
    <!-- Logo + Brand -->
    <div class="brand">
        <img src="{{ asset('img/logo-new.png') }}" alt="Lotus Parking Logo">
        <div class="brand-text">
            <span class="lotus">LOTUS</span> <span class="parking">Parking</span>
        </div>
    </div>

    <!-- Header Member -->
    <h1>Portal Member - {{ $member->user->name }}</h1>
    <p>Lokasi: {{ $member->branch->name }}</p>
    <p>No HP: {{ $member->phone }}</p>
    <hr>

    <h2 class="mt-4">Kendaraan & Tagihan</h2>

    @foreach($member->vehicles as $vehicle)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
                <h5 class="mb-0">
                    {{ ucfirst($vehicle->vehicle_type) }} - {{ $vehicle->plate_number }}
                </h5>
                <span class="badge bg-light text-dark">Total: {{ $vehicle->invoices->count() }} Invoice</span>
            </div>
            <div class="card-body bg-dark text-light">
                @forelse($vehicle->invoices as $inv)
                    <div class="invoice-card border rounded p-3 mb-3 bg-light text-dark shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-primary mb-0">Invoice {{ $inv->code }}</h6>
                            <small class="text-muted">{{ $inv->period->format('F Y') }}</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Jumlah:</strong> Rp {{ number_format($inv->amount_cents/100,0,',','.') }}</p>
                                <p class="mb-1"><strong>Status:</strong>
                                    @if($inv->status === 'paid')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ ucfirst($inv->status) }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p class="mb-1"><strong>Jatuh Tempo:</strong> {{ $inv->due_date->format('d-m-Y') }}</p>
                                @if($inv->status === 'paid')
                                    <a href="{{ route('portal.invoices.download', ['invoice'=>$inv->id, 'token'=>$member->portal_token]) }}" 
                                    class="btn btn-sm btn-outline-primary mt-2">📥 Download PDF</a>
                                @else
                                    <small class="text-muted">Silakan upload bukti di bawah.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada invoice untuk kendaraan ini</p>
                @endforelse
            </div>
        </div>
    @endforeach

    <hr>
    <h2>Info Pembayaran</h2>
    <div class="alert alert-info shadow-sm mt-4">
        <p>Silakan transfer ke Virtual Account berikut:</p>
        <h4 class="fw-bold">{{ $virtualAccount }}</h4>
        <p><small>Pastikan menyertakan bukti pembayaran agar pembayaran dapat diverifikasi admin.</small></p>
    </div>
    <hr>
    <h2 class="mb-4">Upload Bukti</h2>
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
    <hr>
    @endforeach
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
<script>
    // Redirect otomatis jika sudah lebih dari 1 hari sejak member dibuat
    document.addEventListener("DOMContentLoaded", function() {
        let createdAt = new Date("{{ $member->created_at }}"); 
        let now = new Date();
        let diff = (now - createdAt) / (1000 * 60 * 60 * 24); // selisih dalam hari

        if (diff > 1) {
            window.location.href = "{{ route('portal.form') }}";
        }
    });
</script>
</body>
</html>
