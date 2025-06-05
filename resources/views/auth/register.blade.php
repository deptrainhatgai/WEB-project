<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="{{ asset('css/style-chung.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        .alert-success {
            color: green;
            background-color: #e6ffe6;
            border: 1px solid green;
            padding: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-success button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="/">Ngọc Ánh</a>
            </div>
        </header>
        <main class="auth-container">
            <div class="form-wrapper register-wrapper">
                <h2>Đăng Ký</h2>

                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                        <button onclick="window.location.href='{{ route('login') }}'">Đóng</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
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
                    <div class="form-group">
                        <label for="password_confirmation">Nhập lại mật khẩu:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Đăng Ký</button>
                        <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
        </main>
        <footer>
        </footer>
    </div>
</body>
</html>