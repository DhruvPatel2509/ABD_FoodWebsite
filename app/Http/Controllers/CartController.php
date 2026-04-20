<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🛒 Show Cart
    public function index()
    {
        return view('cart');
    }

    // ➕ Add to Cart (Updated to use Product Image Path)
    public function addToCart($id)
    {
        // Eager load images to avoid multiple database queries
        $product = FoodItem::with('images')->findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            /** * FIX: We use $product->image_url.
             * This accessor (in the FoodItem model) logic:
             * 1. Looks at the 'images' relationship.
             * 2. Grabs the first FoodImage.
             * 3. Returns the path from /images/products/.
             */
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url // Pulls from food_images table
            ];
        }

        session()->put('cart', $cart);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'count' => count($cart),
                'message' => 'Added to cart'
            ]);
        }

        return redirect()->back()->with('success', 'Dish added to your cart!');
    }

    // 🔄 Update Quantity (+ / −)
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false], 404);
        }

        $delta = (int) ($request->delta ?? 0);
        $cart[$id]['quantity'] += $delta;

        if ($cart[$id]['quantity'] <= 0) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => count($cart)
        ]);
    }

    // ❌ Remove Item
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed successfully');
    }

    // 💳 Place Order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'address' => 'required',
        ]);

        $cart = session()->get('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Coupon Logic
        $discount_amount = 0;
        $coupon_code = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            $coupon_code = $coupon['code'];

            $discount_amount = ($coupon['type'] === 'percent')
                ? ($total * $coupon['value']) / 100
                : $coupon['value'];
        }

        $final_total = max(0, $total - $discount_amount);

        // Create Order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $final_total,
            'status' => 'pending',
            'address' => $request->address,
            'phone' => $request->phone,
            'payment_method' => strtolower($request->payment_method ?? 'cod'),
            'payment_transaction_id' => $request->upi_transaction_id ?? null,
            'coupon_code' => $coupon_code,
            'discount_amount' => $discount_amount,
        ]);

        // Save Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_item_id' => $id,
                'food_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget(['cart', 'coupon']);

        return redirect()->route('order.track', $order->id)
            ->with('success', 'Order Placed Successfully! 🍽️');
    }

    // 💳 Checkout View
    public function checkout()
    {
        return view('checkout');
    }

    // 🎟️ Apply Coupon
    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required']);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code!');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    // ❌ Remove Coupon
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed!');
    }

    // 📊 Cart Metadata (Total/Count)
    public function cartData()
    {
        $cart = session('cart', []);
        $total = 0;
        $count = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $count += $item['quantity'];
        }

        return response()->json(['count' => $count, 'total' => $total]);
    }

    // 🛒 Cart Items List
    public function cartItems()
    {
        return response()->json(session('cart', []));
    }
}