<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa thông tin (nếu bạn có trang riêng cho việc này).
     */
    public function edit()
    {
        return view('profile.edit'); // Hoặc trang nào bạn dùng để hiển thị form
    }

    /**
     * Xử lý việc cập nhật thông tin người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Cập nhật các trường thông tin
        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');
        $user->birthdate = $request->input('birthdate');
        $user->address = $request->input('address');
        $user->save();

        // Chuyển hướng người dùng trở lại trang tài khoản với thông báo thành công
        return redirect()->route('account.info')->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');
    }

    /**
     * Xử lý việc xóa tài khoản (nếu bạn có chức năng này).
     */
    public function destroy(Request $request)
    {
        // Logic xóa tài khoản
    }
}