<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function show(Product $product)
    {
        // Laravel akan otomatis mencari produk berdasarkan slug di URL
        return view('product-detail', compact('product'));
    }

    public function index()
    {
        // Ambil semua produk yang statusnya 'Tersedia'
        $products = Product::where('status', 'Tersedia')->latest()->get();

        // Kirim data produk ke view 'welcome'
        return view('welcome', compact('products'));
    }
}
