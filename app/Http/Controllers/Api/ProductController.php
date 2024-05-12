<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return ProductCollection::make($products);
    }
}
