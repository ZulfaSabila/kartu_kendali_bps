<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk — Kartu Kendali BPS Kota Bontang</title>

    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bps.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bps-blue: #003366;
            --bps-green: #00A651;
            --text-dark: #333333;
            --bg-right: #F5F7FA;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-right);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .login-left {
            background-color: #1e3a5f;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: white;
            position: relative;
            text-align: center;
            min-height: 100vh;
        }

        .login-right {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            background-color: var(--bg-right);
            min-height: 100vh;
        }

        .login-card {
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.10), 0 1.5px 6px rgba(0,0,0,0.06);
            width: 100%;
            max-width: 420px;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 28px 20px;
                margin: 16px;
            }
        }

        .bps-logo-circle {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .bps-logo-circle span {
            color: var(--bps-blue);
            font-size: 3rem;
            font-weight: 800;
        }

        .btn-bps {
            background-color: #1e3a5f;
            color: white;
            font-weight: 600;
            padding: 13px;
            font-size: 15px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
            cursor: pointer;
            margin-top: 24px;
        }

        .btn-bps:hover {
            background-color: var(--bps-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 166, 81, 0.2);
        }

        .input-field {
            width: 100%;
            background-color: #f0f4f8;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .input-field:focus {
            border-color: #1e3a5f;
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #718096;
        }

        .tagline-bottom {
            position: absolute;
            bottom: 2rem;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-left {
                width: 100%;
                padding: 4rem 2rem;
                min-height: auto;
            }
            .login-right {
                width: 100%;
                padding: 3rem 1.5rem;
            }
            .tagline-bottom {
                position: static;
                margin-top: 3rem;
            }
        }
    </style>
</head>
<body x-data="{ showPassword: false }">
    <div class="login-container">
        <!-- LEFT SIDE: Branding -->
        <div class="login-left">
            <div class="bps-logo-circle">
                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" style="width: 80px; height: auto;">
            </div>
            <h1 style="font-size: 22px; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: 1px;">BADAN PUSAT STATISTIK</h1>
            <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 1.5rem; letter-spacing: 3px; margin-top: 4px;">KOTA BONTANG</h2>
            <p style="font-size: 13px; opacity: 0.75; max-width: 300px; line-height: 1.5; margin-top: 16px;">
                Sistem Informasi Kartu Kendali BMN
            </p>
            
            <div class="tagline-bottom">
                © 2026 BPS Kota Bontang
            </div>
        </div>

        <!-- RIGHT SIDE: Form -->
        <div class="login-right">
            <div class="login-card">
                <div style="margin-bottom: 32px; text-align: center;">
                    <h3 style="font-size: 28px; font-weight: 800; color: #1e3a5f; margin-bottom: 8px; letter-spacing: -0.5px;">Masuk ke Sistem</h3>
                    <p style="color: #64748b; font-size: 14px; font-weight: 500;">Sistem Informasi Kartu Kendali BMN</p>
                    <div style="width: 40px; height: 3px; background: #1e3a5f; margin: 12px auto 0; border-radius: 2px; opacity: 0.15;"></div>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Email</label>
                        <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@bps.go.id" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Password</label>
                        <div style="position: relative;">
                            <input id="password" class="input-field" 
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required autocomplete="current-password" 
                                    placeholder="••••••••" />
                            <span class="password-toggle" @click="showPassword = !showPassword">
                                <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                            <input id="remember_me" type="checkbox" name="remember" style="width: 1rem; height: 1rem; border-radius: 0.25rem; border: 1px solid #CBD5E0; color: var(--bps-blue); focus:ring-var(--bps-blue);">
                            <span style="margin-left: 0.5rem; font-size: 13px; color: #374151;">Ingat Saya</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 13px; color: #1e3a5f; text-decoration: none; font-weight: 500;">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="btn-bps">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
