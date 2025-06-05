<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="stylesheet" href="{{ asset('css/style-chung.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
</head>
<body>
    <div class="container account-page">
        <header>
            <div class="logo">
                <a href="/">Ngọc Ánh</a>
            </div>
        </header>
        <main>
            <h1>Thông tin tài khoản</h1>
            @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
            @if (Auth::check())
                <section class="user-info">
                    <h2>Thông tin cá nhân</h2>
                    <div class="detail-item">
                        <strong>Họ và tên:</strong>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Email:</strong>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Số điện thoại:</strong>
                        <span id="phone">{{ Auth::user()->phone_number ?? 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Năm sinh:</strong>
                        <span id="birthdate">{{ Auth::user()->birthdate ?? 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Địa chỉ:</strong>
                        <span id="address">{{ Auth::user()->address ?? 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Ngày tạo tài khoản:</strong>
                        <span>{{ Auth::user()->created_at->format('d-m-Y H:i:s') }}</span>
                    </div>
                    <button id="edit-info-btn">Cập nhật thông tin</button>
                </section>

                <section class="edit-info-form" style="display: none;">
                    <h2>Cập nhật thông tin cá nhân</h2>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Số điện thoại:</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ Auth::user()->phone_number ?? '' }}">
                            @error('phone_number')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birthdate">Năm sinh:</label>
                            <input type="date" id="birthdate" name="birthdate" value="{{ Auth::user()->birthdate ?? '' }}">
                            @error('birthdate')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <textarea id="address" name="address">{{ Auth::user()->address ?? '' }}</textarea>
                            @error('address')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="save-btn">Lưu thông tin</button>
                        <button type="button" id="cancel-edit-btn">Hủy</button>
                    </form>
                </section>

                <section class="change-password">
                    <h2>Đổi mật khẩu</h2>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại:</label>
                            <input type="password" id="current_password" name="current_password" required>
                            @error('current_password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu mới:</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu mới:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit">Đổi mật khẩu</button>
                    </form>
                </section>

                <div class="actions">
                    <a href="{{ route('home') }}" class="back-home-btn">Quay lại trang chủ</a>
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Đăng xuất</button>
                    </form>
                </div>
            @else
                <p>Bạn chưa đăng nhập.</p>
                <a href="{{ route('login') }}">Đăng nhập</a>
            @endif
        </main>
        <footer>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editInfoBtn = document.getElementById('edit-info-btn');
            const editInfoForm = document.querySelector('.edit-info-form');
            const cancelEditBtn = document.getElementById('cancel-edit-btn');
            const userInfoSection = document.querySelector('.user-info');

            if (editInfoBtn && editInfoForm && cancelEditBtn && userInfoSection) {
                editInfoBtn.addEventListener('click', function() {
                    userInfoSection.style.display = 'none';
                    editInfoForm.style.display = 'block';
                });

                cancelEditBtn.addEventListener('click', function() {
                    editInfoForm.style.display = 'none';
                    userInfoSection.style.display = 'block';
                });
            }
        });
    </script>
</body>
</html>