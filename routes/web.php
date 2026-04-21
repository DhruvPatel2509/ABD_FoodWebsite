<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 HOME & MENU
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/full-menu', [HomeController::class, 'fullMenu'])->name('full.menu');
Route::view('/about', 'about')->name('about');

// 📂 CATEGORY + FOOD
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/food/{slug}', [HomeController::class, 'show'])->name('food.show');

// 🛒 CART
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart-data', [CartController::class, 'cartData']);
Route::get('/cart-items', [CartController::class, 'cartItems']);

// 🔍 SEARCH (Live Dropdown + Search Page)
Route::get('/quick-search', [HomeController::class, 'quickSearch']);
Route::get('/search-food', [HomeController::class, 'search']);

// 🔐 AUTH PROTECTED
Route::middleware(['auth'])->group(function () {
    // 💳 CHECKOUT
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [CartController::class, 'placeOrder'])->name('order.place');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');

    // 📦 USER ORDERS
    Route::get('/my-orders', [OrderController::class, 'index'])->name('user.orders');
    Route::view('/order-success', 'order-success')->name('order.success');
    Route::get('/order/{id}/track', [OrderController::class, 'track'])->name('order.track');
    Route::get('/order/{id}/receipt', [OrderController::class, 'receipt'])->name('order.receipt');

    // 👤 PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🌐 SOCIAL LOGIN
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('social.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';

// ==========================================
// ADMIN PANEL ROUTES
// ==========================================
Route::get('/Adminlogin', [AuthController::class, 'login'])->middleware('guest')->name('admin.login');
Route::post('/loginProcess', [AuthController::class, 'loginProcess'])->middleware('guest');
Route::post('/signupProcess', [AuthController::class, 'signupProcess'])->middleware('guest');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    // Categories
    Route::get('/admin/categories', [CategoryController::class, 'allCategories']);
    Route::get('/admin/categories/show/{id}', [CategoryController::class, 'showCategory']);
    Route::get('/admin/categories/create', function () {
        return view('admin.createCategories'); });
    Route::post('/admin/categories/store', [CategoryController::class, 'store']);
    Route::get('/admin/categories/edit/{id}', [CategoryController::class, 'editCategory']);
    Route::post('/admin/categories/updateCat/{id}', [CategoryController::class, 'updateCategory']);
    Route::get('/admin/categories/delete/{id}', [CategoryController::class, 'deleteCategory']);

    // Products
    Route::get('/admin/products', [ProductsController::class, 'allProducts']);
    Route::get('/admin/products/create', [ProductsController::class, 'create']);
    Route::post('/admin/products/store', [ProductsController::class, 'store']);
    Route::get('/admin/products/edit/{id}', [ProductsController::class, 'editProduct']);
    Route::post('/admin/products/update/{id}', [ProductsController::class, 'updateProduct']);
    Route::get('/admin/products/delete/{id}', [ProductsController::class, 'deleteProduct']);

    // Orders & Users
    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::get('/admin/viewOrder/{id}', [OrderController::class, 'adminShow']);
    Route::post('/admin/orders/update-status/{id}', [OrderController::class, 'updateStatus']);
    Route::get('/admin/users', [AuthController::class, 'allUsers']);
    Route::get('/admin/userEdit/{id}', [AuthController::class, 'editUser']);
    Route::post('/admin/user/update/{id}', [AuthController::class, 'updateUser']);
    Route::get('/admin/deleteUser/{id}', [AuthController::class, 'deleteUser']);
});