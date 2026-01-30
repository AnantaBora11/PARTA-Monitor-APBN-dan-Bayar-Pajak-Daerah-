<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PARTA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400..800&family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Manrope', sans-serif; 
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .bg-image {
            position: fixed;
            inset: 0;
            z-index: 0;
        }
        .bg-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(2px);
            z-index: 1;
        }
        .glass-card { 
            position: relative;
            z-index: 10;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 3rem; 
            border-radius: 2rem; 
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%; 
            max-width: 420px;
            margin: 1rem;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .logo img {
            height: 40px;
            width: auto;
        }
        .logo span {
            font-family: 'Baloo Bhai 2', cursive;
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 0.5rem;
            font-family: 'Baloo Bhai 2', cursive;
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }
        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        .form-group { margin-bottom: 1.25rem; }
        label { 
            display: block; 
            margin-bottom: 0.5rem; 
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            font-weight: 500;
            padding-left: 0.25rem;
        }
        input { 
            width: 100%; 
            padding: 1rem 1.25rem; 
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 0.75rem;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background: rgba(0, 0, 0, 0.3);
        }
        button { 
            width: 100%; 
            padding: 1rem; 
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white; 
            border: none; 
            border-radius: 0.75rem; 
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.5);
        }
        button:hover { 
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(59, 130, 246, 0.6);
        }
        .error-list {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .error-list ul {
            list-style: none;
            color: #fca5a5;
            font-size: 0.875rem;
        }
        .link { 
            margin-top: 1.5rem; 
            text-align: center; 
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        a { 
            color: #60a5fa; 
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #93c5fd;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }
        .divider span {
            padding: 0 1rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <!-- Background Image -->
    <div class="bg-image">
        <img src="{{ asset('image/dashboard.jpg') }}" alt="Background">
    </div>
    <div class="bg-overlay"></div>

    <div class="glass-card">
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="PARTA Logo">
            <span>PARTA</span>
        </div>
        
        <h2>Selamat Datang</h2>
        <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>
        
        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Masuk</button>
        </form>
        
        <div class="link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
    </div>
</body>
</html>
