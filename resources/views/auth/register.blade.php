<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PARTA</title>
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
            overflow-x: hidden;
            padding: 2rem 0;
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
            padding: 2.5rem; 
            border-radius: 2rem; 
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%; 
            max-width: 480px;
            margin: 1rem;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .logo img {
            height: 36px;
            width: auto;
        }
        .logo span {
            font-family: 'Baloo Bhai 2', cursive;
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 0.5rem;
            font-family: 'Baloo Bhai 2', cursive;
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
        }
        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-group { margin-bottom: 1rem; }
        .form-group.full-width {
            grid-column: span 2;
        }
        label { 
            display: block; 
            margin-bottom: 0.4rem; 
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            font-weight: 500;
            padding-left: 0.25rem;
        }
        input { 
            width: 100%; 
            padding: 0.875rem 1rem; 
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 0.75rem;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        input:focus {
            outline: none;
            border-color: rgba(16, 185, 129, 0.5);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(0, 0, 0, 0.3);
        }
        button { 
            width: 100%; 
            padding: 1rem; 
            background: linear-gradient(135deg, #10b981, #059669);
            color: white; 
            border: none; 
            border-radius: 0.75rem; 
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
            margin-top: 0.5rem;
        }
        button:hover { 
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.6);
        }
        .error-msg {
            color: #fca5a5;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            padding-left: 0.25rem;
        }
        .link { 
            margin-top: 1.5rem; 
            text-align: center; 
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }
        a { 
            color: #34d399; 
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #6ee7b7;
        }

        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
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
        
        <h2>Buat Akun Baru</h2>
        <p class="subtitle">Daftarkan dirimu untuk mengakses layanan pajak</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" required>
                    @error('nik')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama sesuai KTP" required>
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
