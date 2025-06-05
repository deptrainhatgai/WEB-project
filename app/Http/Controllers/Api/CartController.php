<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng của người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy mục giỏ hàng.'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $totalPrice = $user->carts()->with('product')->get()->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        $cartCount = $user->carts()->sum('quantity');

        return response()->json([
            'success' => true,
            'total_price' => $totalPrice,
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Xóa một sản phẩm khỏi giỏ hàng của người dùng.
     *
     * @param  int  $cartId
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($cartId)
    {
        $user = Auth::user();

        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', $user->id)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy mục giỏ hàng.'], 404);
        }

        $cartItem->delete();

        $totalPrice = $user->carts()->with('product')->get()->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        $cartCount = $user->carts()->sum('quantity');

        return response()->json([
            'success' => true,
            'total_price' => $totalPrice,
            'cart_count' => $cartCount,
        ]);
    }
    public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'nullable|integer|min:1',
    ]);

    $user = Auth::user();

    if ($user) {
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->input('quantity', 1);
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->input('quantity', 1),
            ]);
        }
        return response()->json(['count' => $user->carts()->sum('quantity')]);
    } else {
        return response()->json(['message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.'], 401);
    }
}

    public function count()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['count' => 0]);
        }

        return response()->json(['count' => $user->carts()->sum('quantity')]);
    }

public function showCartPage()
{
    $cartItems = collect([]); // Mảng rỗng mặc định
    $totalPrice = 0;

    if (Auth::check()) {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });
    }

    return view('cart.index', compact('cartItems', 'totalPrice'));
}
public function sync(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Người dùng chưa đăng nhập.'], 401);
    }

    $items = $request->input('items', []);

    foreach ($items as $item) {
        $productId = $item['productId'] ?? null;
        $quantity = $item['quantity'] ?? 1;

        if ($productId) {
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }
    }

    return response()->json(['success' => true]);
}
}
