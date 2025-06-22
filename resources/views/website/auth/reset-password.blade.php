<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>SILATAD - Fakultas Ilmu Komputer</title>
        <meta content="Sistem Informasi Pelayanan Administrasi Terpadu Civitas Akamedik" name="description">
        <meta content="Sistem Informasi Pelayanan Administrasi Terpadu Civitas Akamedik" name="keywords">

        @include('website.partials.style')
        <style>
            :root {
                --primary-color: #4154f1;
            }
            html, body {
                height: 100%;
                margin: 0;
                background-color: #f8f9fa;
            }
            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .login-form {
                width: 100%;
                max-width: 400px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            .btn-primary:hover {
                background-color: #2f41d1;
                border-color: #2f41d1;
            }
            .logo span {
                font-size: 30px;
                font-weight: 700;
                letter-spacing: 1px;
                color: #012970;
                font-family: "Nunito", sans-serif;
                margin-top: 3px;
            }
            .logo img {
                max-height: 40px;
                margin-right: 6px;
            }
            a {
                color: var(--primary-color);
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
            /* Styling untuk pesan error */
            .invalid-feedback {
                display: block;
                font-size: 0.875em;
                color: #dc3545; /* Warna merah Bootstrap */
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-form">
                <a href="{{ route('index') }}" class="logo d-flex align-items-center justify-content-center mb-2">
                    <img src="{{ asset('website/img/logo-upn.png') }}" alt="logo upn">
                    <span>SILATAD</span>
                </a>

                <form action="{{ route('password.store') }}" method="POST">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="*****@student.upnjatim.ac.id" required value="{{ old('email', $request->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password di atas" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>

        @include('website.partials.script')
    </body>
</html>
