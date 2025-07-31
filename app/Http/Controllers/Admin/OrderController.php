<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', "Status pesanan #{$order->id} berhasil diupdate.");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', "Pesanan #{$order->id} berhasil dihapus.");
    }

    public function downloadInvoice(Order $order)
    {
        $order->load('user', 'items.product');
        $pdf = Pdf::loadView('invoice', compact('order'));

        // Ganti 'download' menjadi 'stream'
        return $pdf->stream('invoice-otomov-'.$order->id.'.pdf');
    }
}
