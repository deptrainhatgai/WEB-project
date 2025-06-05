<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



# 🎂 Website Bán Bánh Kem - Laravel Project

## 👤 Thông tin sinh viên

- **Họ và tên:** Nguyễn Quốc Thành 
- **Mã sinh viên:** 23010038 
- **Môn học:** Lập trình Web - Bài tập giữa kỳ

---

## 📌 Mục tiêu dự án

Xây dựng một ứng dụng web bán bánh kem trực tuyến với các chức năng:
- Hiển thị sản phẩm bánh kem theo danh mục
- Cho phép khách hàng đặt hàng thông qua giỏ hàng
- Xác thực người dùng (Laravel Breeze)
- Quản lý sản phẩm (CRUD)
- Bảo mật và xác thực dữ liệu
- Sử dụng MySQL Cloud (Aiven) và Eloquent để quản lý dữ liệu

---

## 🛠️ Công nghệ sử dụng

- **Ngôn ngữ:** PHP, Blade, HTML, CSS
- **Framework:** Laravel 11
- **Xác thực:** Laravel Breeze (Auth)
- **Database:** MySQL (trên nền tảng Aiven)
- **Quản lý phiên:** Session, Cookie
- **Bảo mật:** CSRF, XSS, Validation, Authorization
- **Source Control:** Git & GitHub

---

## 🧱 Các đối tượng chính (Models)

- `Product`: Bánh kem (id, tên, mô tả, giá, hình ảnh, loại bánh)
- `Customer`: Người dùng có thể đăng ký, đăng nhập, mua hàng
- `CartItem`: Quan hệ giữa Customer và Product, chứa số lượng và giá

---

## 🔐 Tính năng bảo mật áp dụng

- CSRF protection cho các form
- Validation đầu vào ở cả client và server
- Chống XSS bằng `{{ }}` và HTML Purifier (nếu có)
- Xác thực người dùng và phân quyền với middleware
- Sử dụng session và cookies an toàn
- Truy vấn qua Eloquent ORM tránh SQL injection

---

## 🔄 CRUD Được triển khai

- ✅ CRUD cho `CartItem` (thêm vào giỏ, cập nhật số lượng, xoá)
- ✅ CRUD nội bộ Laravel Breeze cho `User` (Register/Login)

---

## ☁️ Cơ sở dữ liệu

- Hệ quản trị CSDL: MySQL trên nền tảng **Aiven Cloud**
- Migrations được tạo bằng **Eloquent**
- Seeders có thể tạo dữ liệu mẫu bánh kem để demo

---

## 🚀 Cài đặt & chạy thử

```bash
git clone https://github.com/deptrainhatgai/WEB-project.git
cd cake-shop
composer install
cp .env.example .env
php artisan key:generate

# Kết nối Aiven MySQL (chỉnh DB trong .env)
php artisan migrate --seed

php artisan serve

