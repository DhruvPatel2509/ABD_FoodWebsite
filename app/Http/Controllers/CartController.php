<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🛒 Show Cart
    public function index()
    {
        return view('cart');
    }

    // ➕ Add to Cart (AJAX READY ✅)
    public function addToCart($id)
    {
        $product = FoodItem::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => optional($product->images()->first())->image_path
            ];
        }

        session()->put('cart', $cart);

        // ✅ AJAX REQUEST HANDLE
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'count' => count($cart),
                'message' => 'Added to cart'
            ]);
        }

        // Normal fallback
        return redirect()->back()->with('success', 'Dish added to your ABD cart!');
    }

    // 🔄 Update Quantity (+ / −)
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false], 404);
        }

        $delta = $request->delta ?? 0;

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

        $discount_amount = 0;
        $coupon_code = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            $coupon_code = $coupon['code'];
            
            if ($coupon['type'] === 'percent') {
                $discount_amount = ($total * $coupon['value']) / 100;
            } else {
                $discount_amount = $coupon['value'];
            }
        }

        $final_total = max(0, $total - $discount_amount);

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

        // ✅ Save specific order items
        foreach ($cart as $id => $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'food_item_id' => $id,
                'food_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.track', $order->id)
            ->with('success', 'ABD Order Placed Successfully! 🍽️');
    }

    // 💳 CHECKOUT VIEW
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

    // 📊 CART DATA (FOR STICKY CART)
    public function cartData()
    {
        $cart = session('cart', []);

        $total = 0;
        $count = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $count += $item['quantity'];
        }

        return response()->json([
            'count' => $count,
            'total' => $total
        ]);
    }

    // 🛒 CART ITEMS (FOR DRAWER)
    public function cartItems()
    {
        return response()->json(session('cart', []));
    }
}