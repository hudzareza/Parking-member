<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LOTUS Parking | Login</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #f0f9ff;
            background-image: url('{{ asset("img/front-img.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease;
        }

        .card h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .card label {
            color: #555;
            font-weight: 600;
        }

        .card input[type="email"],
        .card input[type="password"] {
            margin-top: 6px;
            margin-bottom: 12px;
            padding: 10px 14px;
            border: 2px solid #ddd;
            border-radius: 10px;
            width: 100%;
            transition: border 0.3s ease;
        }

        .card input:focus {
            border-color: #3b82f6;
            outline: none;
        }

        .login-button {
            background: #3b82f6;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .login-button:hover {
            background: #2563eb;
        }

        .link {
            font-size: 14px;
            color: #666;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .link a {
            color: #3b82f6;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
            }

            .card h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        {{ $slot }}
    </div>

</body>
</html>
