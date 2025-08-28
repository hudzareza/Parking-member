<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. ABID INVESTAMA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0 0 30px 0;
            font-size: 32px;
            color: #333;
        }
        .login-btn {
            padding: 10px 30px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <img src="{{ asset('img/abid.png') }}" alt="Logo PT. ABID INVESTAMA">
    <h1>PT. ABID INVESTAMA</h1>
    <h2>Aplikasi laporan dan pembayan member parkir</h2>
    <button class="login-btn" onclick="window.location.href='{{ route('login') }}'">Login</button>
</body>
</html>
