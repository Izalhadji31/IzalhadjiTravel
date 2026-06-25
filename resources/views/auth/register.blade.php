<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        html, body { margin: 0; padding: 0; background: #f8f9fa; }
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .register-box {
            width: 100%;
            max-width: 500px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 0.5rem 0;
        }
        
        .register-logo span { color: #2563eb; }
        
        .register-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #111;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }
        
        .form-error {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-error ul {
            margin: 0.5rem 0 0 0;
            padding-left: 1rem;
        }
        
        .register-button {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .register-button:hover {
            background: #1d4ed8;
        }
        
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .register-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-footer a:hover {
            text-decoration: underline;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <!-- Header -->
            <div class="register-header">
                <h1 class="register-logo"><span>ASR</span> GO</h1>
                <p class="register-subtitle">Buat akun baru Anda</p>
            </div>
            
            <!-- Error Message -->
            @if ($errors->any())
                <div class="alert-error">
                    <strong>Pendaftaran Gagal</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Register Form -->
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="role">Daftar Sebagai</label>
                    <select id="role" name="role" class="form-input">
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Pelanggan (Customer)</option>
                        <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Sopir / Driver</option>
                        <option value="partner" {{ old('role') == 'partner' ? 'selected' : '' }}>Mitra (Partner)</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name') }}"
                            class="form-input"
                            placeholder="John Doe"
                            required
                            autofocus
                        >
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Nomor Telepon</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-input"
                            placeholder="081234567890"
                            required
                        >
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        placeholder="contoh@asrgo.com"
                        required
                    >
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>
                
                <button type="submit" class="register-button">Daftar</button>
            </form>
            
            <!-- Footer -->
            <div class="register-footer">
                <p style="margin: 0;">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
