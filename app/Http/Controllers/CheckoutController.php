<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
// Hapus 'use Barryvdh\DomPDF\Facade\Pdf;' jika tidak ada method lain yang memakainya

class CheckoutController extends Controller
{
    public function store()
    {
        // 1. Buat pesanan baru
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => Cart::total(0, '', ''),
            'status' => 'pending',
        ]);

        // 2. Simpan setiap item di keranjang
        foreach (Cart::content() as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->qty,
            ]);
        }

        // 3. Kosongkan keranjang belanja
        Cart::destroy();

        // 4. Arahkan ke halaman utama dengan pesan sukses
        return redirect()->route('home')->with('success', 'Terima kasih, pesanan Anda telah kami terima!');
    }
}
