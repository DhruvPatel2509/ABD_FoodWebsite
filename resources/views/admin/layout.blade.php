<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

    <head>
        @stack('styles')
    </head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>@yield('title') - Admin</title>
</head>

<body x-data="{ sidebarOpen: true }">
    <div class="sidebar" :class="sidebarOpen ? '' : 'collapsed'">
        <div style="padding: 25px; font-size: 22px; font-weight: 800; white-space: nowrap;">FoodBoss Admin</div>

        <nav style="flex-grow: 1;">
            <a href="/admin/dashboard" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> <span>Dashboard</span>
            </a>
            <a href="/admin/categories" class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i> <span>Categories</span>
            </a>
            <a href="/admin/products" class="nav-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fa-solid fa-burger"></i> <span>Products</span>
            </a>
            <a href="/admin/orders" class="nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i> <span>Orders</span>
            </a>
            <a href="/admin/users" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> <span>Users</span>
            </a>
        </nav>

        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper" :class="sidebarOpen ? '' : 'expanded'">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <button @click="sidebarOpen = !sidebarOpen" class="toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div
                style="background: white; padding: 10px 20px; border-radius: 12px; border: 1px solid #e2e8f0; font-weight: 600;">
                AD admin
            </div>
        </header>
        @yield('content')
    </div>
</body>

</html>