<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cake; // Đổi từ Product sang Cake
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Để kiểm tra xác thực và ủy quyền

class OrderController extends Controller
{
    /**
     * Constructor để áp dụng middleware xác thực.
     */
    public function __construct()
    {
        // Yêu cầu người dùng phải đăng nhập để truy cập các chức năng này
        $this->middleware('auth');
        // Bạn có thể thêm middleware authorization nếu có vai trò người dùng
        // $this->middleware('can:manage-orders');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả các bản ghi Order cùng với thông tin Cake và Customer liên quan
        $orders = Order::with(['cake', 'customer'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cakes = Cake::all(); // Đổi từ products sang cakes
        $customers = Customer::all();
        return view('orders.create', compact('cakes', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 5. Yêu cầu Security: Data Validation
        $request->validate([
            'cake_id' => 'required|exists:cakes,id', // Đổi từ product_id sang cake_id
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Pending,Completed,Cancelled', // Thêm validation cho status
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')
                         ->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Tải lại các mối quan hệ để đảm bảo dữ liệu đầy đủ
        $order->load('cake', 'customer');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $cakes = Cake::all(); // Đổi từ products sang cakes
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'cakes', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // 5. Yêu cầu Security: Data Validation
        $request->validate([
            'cake_id' => 'required|exists:cakes,id', // Đổi từ product_id sang cake_id
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Pending,Completed,Cancelled', // Thêm validation cho status
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')
                         ->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
                         ->with('success', 'Đơn hàng đã được xóa thành công!');
    }
}