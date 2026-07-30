<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Checkout::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Checkout $order)
    {
        $order->load('user', 'items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Checkout $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
