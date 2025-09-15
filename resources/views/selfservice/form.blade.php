<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Member - LOTUS Parking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            color: #fff; /* putih */
        }
        .form-card {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .form-card-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 1rem;
        }
        .form-card-body {
            padding: 1.5rem;
            background: #1e1e1e;
            color: #ddd;
        }
        .vehicle-item {
            background: #2a2a2a;
            border-radius: 8px;
        }
        .btn-custom {
            border-radius: 30px;
            padding: 0.6rem 1.4rem;
            font-weight: 500;
        }
        .btn-success {
            background-color: #1cc88a;
            border: none;
        }
        .btn-success:hover {
            background-color: #17a673;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
        }
        .btn-primary:hover {
            background-color: #375ac2;
        }
        .form-control, .form-select {
            background: #2a2a2a;
            color: #eaeaea;
            border: 1px solid #444;
        }
        .form-control:focus, .form-select:focus {
            background: #2f2f2f;
            color: #fff;
            border-color: #1cc88a;
            box-shadow: 0 0 0 0.25rem rgba(28,200,138,.25);
        }
        .form-control::placeholder {
            color: #ffffff; /* placeholder putih */
            opacity: 1; /* pastikan terlihat jelas */
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Logo + Brand -->
    <div class="brand">
        <img src="{{ asset('img/logo.png') }}" alt="Lotus Parking Logo"> {{-- ganti path sesuai logo Anda --}}
        <div class="brand-text">
            <span class="lotus">LOTUS</span> <span class="parking">Parking</span>
        </div>
    </div>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Judul -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-light">Portal Member</h1>
        <p class="text-light">Daftar baru atau perpanjang member kendaraan Anda</p>
    </div>

    <!-- Pilih Jenis -->
    <div class="mb-4">
        <label for="mode" class="form-label fw-semibold">Pilih Jenis</label>
        <select id="mode" name="mode" class="form-select" onchange="toggleForm()">
            <option value="new" {{ old('mode', 'new') === 'new' ? 'selected' : '' }}>🆕 Member Baru</option>
            <option value="renew" {{ old('mode') === 'renew' ? 'selected' : '' }}>🔄 Perpanjang</option>
        </select>
        <small class="text-light d-block mt-1">
            🆕 <strong>Member Baru:</strong> Daftar kendaraan baru dan buat akun member pertama kali.<br>
            🔄 <strong>Perpanjang:</strong> Memperpanjang masa aktif member kendaraan yang sudah terdaftar.
        </small>
    </div>

    {{-- Form Daftar Baru --}}
    <div id="form-new" class="form-card shadow-sm">
        <div class="form-card-header">
            <h4 class="mb-0">🆕 Pendaftaran Baru</h4>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('portal.register.process') }}">
                @csrf
                <input type="hidden" name="mode" value="new">

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                </div>
                <!-- <div class="mb-3">
                    <label class="form-label">No KTP</label>
                    <input type="text" name="id_card_number" class="form-control" placeholder="16 digit KTP" value="{{ old('id_card_number') }}">
                </div> -->
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <select name="branch_id" class="form-select" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5 class="mt-4 mb-3">🚘 Kendaraan</h5>
                <div id="vehicles-wrapper">
                    <div class="vehicle-item border p-3 mb-2">
                        <label>Jenis Kendaraan</label>
                        <select name="vehicles[0][vehicle_type]" class="form-select" required>
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                        </select>
                        <label class="mt-2">No Polisi</label>
                        <input type="text" name="vehicles[0][plate_number]" class="form-control" placeholder="B 1234 CD" required>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="addVehicle()">+ Tambah Kendaraan</button>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-custom">✅ Daftar Baru</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Perpanjang --}}
    <div id="form-renew" class="form-card shadow-sm" style="display:none;">
        <div class="form-card-header">
            <h4 class="mb-0">🔄 Perpanjangan</h4>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('portal.renew.process') }}">
                @csrf
                <input type="hidden" name="mode" value="renew">

                <div class="mb-3">
                    <label class="form-label">Email atau Nomor HP</label>
                    <input type="text" name="identifier" class="form-control" placeholder="contoh: user@email.com / 08123xxx" value="{{ old('identifier') }}" required>
                </div>

                <h5 class="mt-4 mb-3">➕ Kendaraan Tambahan (opsional)</h5>
                <div id="vehicles-wrapper-renew"></div>
                <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="addVehicle('renew')">+ Tambah Kendaraan</button>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-custom">🔄 Perpanjang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let vehicleIndex = 1;

function toggleForm() {
    const mode = document.getElementById('mode').value;
    document.getElementById('form-new').style.display = (mode === 'new') ? 'block' : 'none';
    document.getElementById('form-renew').style.display = (mode === 'renew') ? 'block' : 'none';
}

// jalankan saat halaman load, biar sesuai old('mode')
document.addEventListener('DOMContentLoaded', () => {
    toggleForm();
});

function addVehicle(formType = 'new') {
    const wrapperId = formType === 'renew' ? 'vehicles-wrapper-renew' : 'vehicles-wrapper';
    const wrapper = document.getElementById(wrapperId);

    const html = `
        <div class="vehicle-item border p-3 mb-2">
            <label>Jenis Kendaraan</label>
            <select name="vehicles[${vehicleIndex}][vehicle_type]" class="form-select" required>
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>
            <label class="mt-2">No Polisi</label>
            <input type="text" name="vehicles[${vehicleIndex}][plate_number]" class="form-control" placeholder="B 1234 CD" required>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    vehicleIndex++;
}
</script>

</body>
</html>
