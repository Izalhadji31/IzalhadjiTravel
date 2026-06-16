<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        html, body { margin: 0; padding: 0; background: #f8f9fa; }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-box {
            width: 100%;
            max-width: 400px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 0.5rem 0;
        }
        
        .login-logo span { color: #2563eb; }
        
        .login-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
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
        
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .login-button {
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
        
        .login-button:hover {
            background: #1d4ed8;
        }
        
        .login-button:active {
            transform: scale(0.98);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .login-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .checkbox-group input {
            cursor: pointer;
        }
        
        .checkbox-group label {
            cursor: pointer;
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Header -->
            <div class="login-header">
                <h1 class="login-logo"><span>ASR</span> GO</h1>
                <p class="login-subtitle">Sistem Manajemen Transportasi</p>
            </div>
            
            <!-- Error Message -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Login Gagal</strong>
                    <ul style="margin: 0.5rem 0 0 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                
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
                        autofocus
                    >
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
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
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <label for="remember">Ingat saya</label>
                    </div>
                </div>
                
                <button type="submit" class="login-button">Login</button>
            </form>
            
            <!-- Footer -->
            <div class="login-footer">
                <p style="margin: 0;">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
