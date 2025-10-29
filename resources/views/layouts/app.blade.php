<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurant Cashier')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        #menu-list::-webkit-scrollbar {
        width: 6px;
       }

        #menu-list::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 4px;
        }`
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg sidebar-transition" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="flex items-center">
                    <i class="fas fa-utensils text-white text-2xl mr-3"></i>
                    <span class="text-white text-xl font-bold">Restaurant</span>
                </div>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Role' }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-5 px-2">
                @if(Auth::user()->role === 'administrator')
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.meja.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-chair mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Kelola Meja
                    </a>
                    <a href="{{ route('admin.menu.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-utensils mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Kelola Menu
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Kelola Users
                    </a>
                @elseif(Auth::user()->role === 'waiter')
                    <a href="{{ route('waiter.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('waiter.pesanan.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-clipboard-list mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('waiter.laporan') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Laporan
                    </a>
                @elseif(Auth::user()->role === 'kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('kasir.transaksi.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-cash-register mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Kelola Transaksi
                    </a>
                    <a href="{{ route('kasir.siap-bayar') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-credit-card mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Pesanan Siap Bayar
                    </a>
                    <a href="{{ route('kasir.hari-ini') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Laporan
                    </a>
                @elseif(Auth::user()->role === 'owner')
                    <a href="{{ route('owner.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('owner.laporan') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Laporan
                    </a>
                @endif
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 hover:text-red-900">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="ml-2 text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span id="current-time"></span>
                        </div>
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
         @click="sidebarOpen = false">
    </div>

    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>