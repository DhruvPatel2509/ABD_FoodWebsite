<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    // 📜 User Order History
    public function index(): View
    {
        // Loading items.foodItem to show product names/images in history if needed
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.foodItem'])
            ->latest()
            ->get();

        return view('orders-history', compact('orders'));
    }

    // 📍 Live Tracking
    public function track(int $id): View
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        return view('live-tracking', compact('order'));
    }

    // 🧾 Order Receipt
    public function receipt(int $id): View
    {
        // Eager loading items and foodItem to display images/details on the receipt
        $order = Order::with(['items.foodItem'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('receipt', compact('order'));
    }

    // 👨‍💼 Admin: List All Orders
    public function adminIndex(): View
    {
        // Eager loading 'user' ensures $order->user->avatar_path works in the list view
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders', compact('orders'));
    }

    // 🔍 Admin: Detailed Order View
    public function adminShow(int $id): View
    {
        // Nested eager loading so we have access to:
        // 1. User Avatars: /images/avatars/
        // 2. Category Images: /images/categories/
        // 3. Product Images: /images/products/
        $order = Order::with([
            'user',
            'items.foodItem.category',
            'items.foodItem.images'
        ])->findOrFail($id);

        return view('admin.orderView', compact('order'));
    }

    // 🔄 Update Order Status
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,delivered,cancelled'],
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        // Standardized redirect back to the order view
        return redirect('/admin/viewOrder/' . $order->id)
            ->with('success', 'Order status updated successfully!');
    }
}