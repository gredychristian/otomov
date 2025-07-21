<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // Menampilkan halaman riwayat pesanan pengguna
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    // Untuk mengunduh invoice PDF
    public function downloadInvoice(Order $order)
    {
        // Pastikan pengguna hanya bisa mengunduh invoice miliknya sendiri
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        $order->load('user', 'items.product');
        $pdf = Pdf::loadView('invoice', compact('order'));

        return $pdf->download('invoice-otomov-' . $order->id . '.pdf');
    }

    // Method show
    public function show(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat order miliknya
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        // Mengirim data order ke view
        return view('orders.show', compact('order'));
    }
}
