<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();

        return view('orders-history', compact('orders'));
    }

    public function track(int $id): View
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        return view('live-tracking', compact('order'));
    }

    public function receipt(int $id): View
    {
        $order = Order::with('items')->where('user_id', auth()->id())->findOrFail($id);

        return view('receipt', compact('order'));
    }

    public function adminIndex(): View
    {
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders', compact('orders'));
    }

    public function adminShow(int $id): View
    {
        $order = Order::with(['user', 'items.foodItem.category', 'items.foodItem.images'])->findOrFail($id);

        return view('admin.orderView', compact('order'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,delivered,cancelled'],
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return redirect('/admin/viewOrder/' . $order->id)->with('success', 'Order status updated successfully!');
    }
}
