<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Đảm bảo import model User

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Đăng nhập thành công
        $request->session()->regenerate(); // Tạo lại ID session
        Auth::login($request->user()); // Đăng nhập người dùng vào session

        return redirect()->intended(route('account.info'));
    }

    // Đăng nhập thất bại, quay lại form đăng nhập với lỗi
    return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
}

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Chuyển hướng trở lại trang register với thông báo thành công
    return redirect()->route('register')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('account.info', compact('user')); // Trả về view và truyền dữ liệu người dùng
    }

    // public function index()
    // {
    //     $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    //     return view('account.info', compact('user'));
    // }
}
