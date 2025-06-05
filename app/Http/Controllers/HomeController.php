<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Thêm logic bạn muốn thực hiện khi truy cập trang chủ ở đây
        return view('home'); // Ví dụ: trả về view 'home.blade.php'
    }
}