<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>LOTUS Parking | PT. ABID INVESTAMA</title>
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            background-repeat: no-repeat;
            background-position: right bottom;
            background-size: 40%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 60px 40px;
            max-width: 900px;
            width: 100%;
            display: flex;
            gap: 40px;
            align-items: center;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content {
            flex: 1;
        }

        .content h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .brand-lotus {
            color: #FFD700;
            font-weight: 700;
        }

        .brand-parking {
            color: #333;
            font-weight: 700;
        }

        .tagline {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        .description {
            font-size: 16px;
            color: #444;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .login-btn {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .login-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .logo-wrapper {
            flex: 1;
            text-align: center;
        }

        .logo-wrapper img {
            max-width: 100%;
            max-height: 300px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column-reverse;
                padding: 40px 20px;
                text-align: center;
            }

            .content h1 {
                font-size: 36px;
            }

            .logo-wrapper {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 480px) {
            .content h1 {
                font-size: 28px;
            }

            .login-btn {
                width: 100%;
            }

            body {
                background-size: 80%;
                background-position: bottom center;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- KONTEN KIRI -->
        <div class="content">
            <h1>
                <span class="brand-lotus">LOTUS</span>
                <span class="brand-parking">Parking</span>
            </h1>
            <div class="tagline">PT. ABID INVESTAMA</div>
            <p class="description">
                Selamat datang di aplikasi <strong>LOTUS Parking</strong> – sistem manajemen parkir modern dari <strong>PT. ABID INVESTAMA</strong>. Aplikasi ini membantu Anda mengelola laporan dan pembayaran member parkir dengan efisien, transparan, dan cepat.
            </p>
            <button class="login-btn" onclick="window.location.href='{{ route('login') }}'">Masuk ke Aplikasi</button>
        </div>

        <!-- LOGO / GAMBAR -->
        <div class="logo-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="Logo PT. ABID INVESTAMA">
        </div>
    </div>

</body>
</html>
