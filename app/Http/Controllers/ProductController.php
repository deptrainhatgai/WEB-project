<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
        }
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => asset($product->image_path),
            'description' => $product->description
        ]);
    }
}
