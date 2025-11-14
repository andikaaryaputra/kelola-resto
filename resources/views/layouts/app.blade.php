<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurant Cashier')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r sidebar-transition"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b">
                <span class="text-black text-xl font-bold">Restaurant</span>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Role' }}</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-5 px-2">

                @if(Auth::user()->role === 'administrator')
                    <a href="{{ route('admin.dashboard') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.meja.index') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Kelola Meja
                    </a>
                    <a href="{{ route('admin.menu.index') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Kelola Menu
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Kelola Users
                    </a>

                @elseif(Auth::user()->role === 'waiter')
                    <a href="{{ route('waiter.dashboard') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Dashboard
                    </a>
                    <a href="{{ route('waiter.pesanan.index') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('waiter.laporan') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Laporan
                    </a>

                @elseif(Auth::user()->role === 'kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Dashboard
                    </a>
                    <a href="{{ route('kasir.transaksi.index') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Kelola Transaksi
                    </a>
                    <a href="{{ route('kasir.siap-bayar') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Pesanan Siap Bayar
                    </a>
                    <a href="{{ route('kasir.hari-ini') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Laporan
                    </a>

                @elseif(Auth::user()->role === 'owner')
                    <a href="{{ route('owner.dashboard') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Dashboard
                    </a>
                    <a href="{{ route('owner.laporan') }}" class="block px-2 py-2 text-sm rounded-md text-black hover:bg-gray-200">
                        Laporan
                    </a>
                @endif

            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-2 py-2 text-sm rounded-md text-red-600 hover:bg-red-200">
                        Logout
                    </button>
                </form>
            </div>

        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">

            <!-- Top Bar -->
            <header class="bg-white border-b">
                <div class="flex items-center justify-between px-4 py-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-200">
                        Menu
                    </button>

                    <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         @click="sidebarOpen = false">
    </div>

</body>
</html>
