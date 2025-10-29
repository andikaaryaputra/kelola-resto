<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Cashier System - Luxury Gold Edition</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    /* Background gold elegan */
    body {
      background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 40%, #f5deb3 100%);
      background-attachment: fixed;
      color: #4a3f28;
    }

    .floating {
      animation: floating 8s ease-in-out infinite;
    }

    @keyframes floating {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      25% { transform: translateY(-20px) rotate(2deg); }
      50% { transform: translateY(-10px) rotate(-1deg); }
      75% { transform: translateY(-15px) rotate(1deg); }
    }

    .card-hover {
      transition: all 0.4s ease;
    }

    .card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 25px 60px rgba(212, 175, 55, 0.3);
    }

    .luxury-glow {
      box-shadow: 0 0 30px rgba(212, 175, 55, 0.25);
    }

    .btn-premium {
      background: linear-gradient(135deg, #d4af37, #e4c27a);
      color: white;
      font-weight: 600;
      padding: 14px 36px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
      transition: all 0.3s ease;
    }

    .btn-premium:hover {
      transform: translateY(-3px);
      box-shadow: 0 20px 40px rgba(212, 175, 55, 0.6);
    }

    .title-glow {
      text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
    }
  </style>
</head>

<body class="relative min-h-screen overflow-x-hidden">

  <!-- Background Elemen Glow -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-200 opacity-20 rounded-full blur-3xl floating"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-300 opacity-10 rounded-full blur-3xl floating" style="animation-delay: 2s;"></div>
  </div>

  <!-- Navbar -->
  <nav class="relative z-10 p-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="flex items-center">
        <i class="fas fa-utensils text-yellow-700 text-3xl mr-3"></i>
        <span class="text-yellow-800 text-2xl font-bold">Restaurant Cashier</span>
      </div>
      <div class="flex items-center space-x-4">
        @auth
          <a href="{{ url('/dashboard') }}" class="text-yellow-800 font-medium hover:text-yellow-600">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
            <button type="submit" class="text-yellow-800 font-medium hover:text-yellow-600">Logout</button>
          </form>
        @else
          <a href="{{ route('login.form') }}" class="btn-premium text-sm">Login</a>
        @endauth
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 text-center">
    <h1 class="text-6xl font-bold text-yellow-800 mb-6 title-glow">
      Restaurant Cashier
      <span class="block text-3xl text-yellow-600 mt-3 font-light">Luxury Management System</span>
    </h1>
    <p class="text-lg text-yellow-900 mb-10 max-w-3xl mx-auto">
      Sistem manajemen kasir restoran yang <b>modern</b>, <b>efisien</b>, dan <b>mewah</b>.  
      Kelola meja, menu, dan transaksi dengan pengalaman premium.
    </p>

    @guest
      <a href="{{ route('login.form') }}" class="btn-premium inline-block text-lg">
        <i class="fas fa-sign-in-alt mr-2"></i> Mulai Sekarang
      </a>
    @endguest
  </div>

  <!-- Fitur -->
  <section class="relative z-10 max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
    <div class="bg-white/80 rounded-3xl p-8 text-center card-hover luxury-glow border border-yellow-300">
      <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
        <i class="fas fa-crown text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-yellow-800 mb-2">Admin</h3>
      <p class="text-yellow-900 text-sm mb-3">Kelola meja dan menu restoran</p>
    </div>

    <div class="bg-white/80 rounded-3xl p-8 text-center card-hover luxury-glow border border-yellow-300">
      <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
        <i class="fas fa-user-tie text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-yellow-800 mb-2">Waiter</h3>
      <p class="text-yellow-900 text-sm mb-3">Kelola pesanan dan pelanggan</p>
    </div>

    <div class="bg-white/80 rounded-3xl p-8 text-center card-hover luxury-glow border border-yellow-300">
      <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
        <i class="fas fa-cash-register text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-yellow-800 mb-2">Kasir</h3>
      <p class="text-yellow-900 text-sm mb-3">Proses pembayaran dan transaksi</p>
    </div>

    <div class="bg-white/80 rounded-3xl p-8 text-center card-hover luxury-glow border border-yellow-300">
      <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
        <i class="fas fa-chart-line text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-yellow-800 mb-2">Owner</h3>
      <p class="text-yellow-900 text-sm mb-3">Pantau performa restoran</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="relative z-10 text-center py-10 border-t border-yellow-300 mt-10">
    <p class="text-yellow-900">© 2025 Restaurant Cashier System. Designed with <span class="text-yellow-700 font-semibold">Luxury Style</span>.</p>
  </footer>

</body>
</html>
