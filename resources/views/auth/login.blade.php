<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="{{ asset('css/style-chung.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="/">Ngọc Ánh</a>
            </div>
        </header>
        <main class="auth-container">
            <div class="form-wrapper login-wrapper">
                <h2>Đăng Nhập</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                        <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
                    </div>
                </form>
            </div>
        </main>
        <footer>
            </footer>
    </div>
</body>
</html>