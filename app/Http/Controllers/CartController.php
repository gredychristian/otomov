<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart; // <-- Ganti use statement

class CartController extends Controller
{
    public function index()
    {
        // Mengambil isi keranjang
        $cartItems = Cart::content();
        return view('cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));

        // Menambahkan item ke keranjang
        Cart::add(
            $product->id,
            $product->name,
            $request->input('quantity'),
            $product->price,
            ['image' => $product->image] // Opsi tambahan seperti gambar
        );

        return redirect()->route('cart.index')->with('success', 'Kendaraan berhasil ditambahkan ke keranjang!');
    }

    public function destroy($rowId)
    {
        // Menghapus item berdasarkan rowId uniknya
        Cart::remove($rowId);
        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}