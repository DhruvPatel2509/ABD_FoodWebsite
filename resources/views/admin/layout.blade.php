<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <script src="https://unpkg.com/feather-icons"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <title>@yield('title', 'Admin Panel')</title>
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, profileOpen: false }" class="flex min-h-screen">
        <aside :class="sidebarOpen ? 'translate-x-0 w-72 lg:w-72' : '-translate-x-full w-72 lg:translate-x-0 lg:w-20'"
            class="fixed inset-y-0 left-0 z-40 h-auto flex-shrink-0 border-r border-red-500 bg-gradient-to-b from-red-600 to-rose-600 text-white transition-all duration-300 lg:static lg:z-auto flex flex-col">
            <div class="flex h-16 items-center justify-between border-b border-white/25 px-4">
                <span x-show="sidebarOpen" class="text-lg font-semibold tracking-wide text-white">FoodBoss Admin</span>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="rounded-md p-2 text-white/80 transition hover:bg-white/20 hover:text-white">
                    <i data-feather="menu" class="h-4 w-4"></i>
                </button>
            </div>

            @php
                $activeClass = 'bg-white text-red-600 border border-white/60 shadow-sm';
                $baseClass = 'border border-transparent text-white/90 hover:bg-white/15 hover:text-white';
            @endphp

            <nav class="flex-1 space-y-2 overflow-y-auto px-3 py-4">
                <a href="/admin/dashboard"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->is('admin/dashboard') ? $activeClass : $baseClass }}">
                    <i data-feather="home" class="h-4 w-4"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <a href="/admin/categories"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? $activeClass : $baseClass }}">
                    <i data-feather="grid" class="h-4 w-4"></i>
                    <span x-show="sidebarOpen">Categories</span>
                </a>

                <a href="/admin/products"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->is('admin/products') || request()->is('admin/products/*') ? $activeClass : $baseClass }}">
                    <i data-feather="box" class="h-4 w-4"></i>
                    <span x-show="sidebarOpen">Products</span>
                </a>

                <a href="/admin/orders"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->is('admin/orders') || request()->is('admin/orders/*') || request()->is('admin/viewOrder/*') ? $activeClass : $baseClass }}">
                    <i data-feather="shopping-cart" class="h-4 w-4"></i>
                    <span x-show="sidebarOpen">Orders</span>
                </a>

                <a href="/admin/users"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->is('admin/users') || request()->is('admin/userEdit/*') ? $activeClass : $baseClass }}">
                    <i data-feather="users" class="h-4 w-4"></i>
                    <span x-show="sidebarOpen">Users</span>
                </a>
            </nav>

            <div class="border-t border-white/25 p-3">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-rose-50">
                        <i data-feather="log-out" class="h-4 w-4"></i>
                        <span x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/20 lg:hidden">
        </div>

        <div class="flex min-h-screen flex-1 flex-col">
            <header
                class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 px-4 py-3 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="inline-flex rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-50 lg:hidden">
                            <i data-feather="menu" class="h-4 w-4"></i>
                        </button>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Admin Panel</p>
                            <h1 class="text-base font-semibold text-slate-800">@yield('header_title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="relative">
                        <button @click="profileOpen = !profileOpen"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2 py-1.5 transition ">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-700">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}</span>
                            <span class="hidden text-sm font-medium text-slate-700 sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </button>


                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>
