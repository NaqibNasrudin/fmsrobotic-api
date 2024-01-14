<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $productId = $this->generateRandomId();
        $product = Product::create([
            'product_id' => $productId,
            'name' => $request->name,
            'status' => 'Miling',
            'qty' => $request->qty,
            'approval' => 'Pending',
            'pic' => $request->pic,
        ]);

        $data['product'] = $product;

        $response = [
            'status' => 'success',
            'message' => 'Product Added !',
            'data' => $data,
        ];

        return response()->json($response, 201);
    }

    private function generateRandomId() {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, 5);
    }

    public function getAllProduct() {
        $products = Product::all();

        if (is_null($products->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No product found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Products are retrieved successfully.',
            'data' => $products,
        ];

        return response()->json($response, 200);
    }

    public function searchProduct(Request $request) {
        $item = $request->item;
        $product = Product::where('product_id', 'LIKE', '%'.$item.'%')->orWhere('name', 'LIKE', '%'.$item.'%')->get();

        $response = [
            'status' => 'success',
            'message' => 'Products are retrieved successfully.',
            'data' => $product,
        ];

        return response()->json($response, 200);
    }
}
