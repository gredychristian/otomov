<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        $order->load('user', 'items.product');
        $pdf = Pdf::loadView('invoice', compact('order'));

        // Ganti 'download' menjadi 'stream'
        return $pdf->stream('invoice-otomov-'.$order->id.'.pdf');
    }
}
