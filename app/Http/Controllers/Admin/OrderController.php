<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        // Validasi sederhana
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        // Update status pesanan
        $order->update(['status' => $request->status]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', "Status pesanan #{$order->id} berhasil diupdate.");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', "Pesanan #{$order->id} berhasil dihapus.");
    }

    // Method show
    public function show(Order $order)
    {
        // Admin bisa melihat semua order, jadi tidak perlu pengecekan
        return view('orders.show', compact('order'));
    }
}
