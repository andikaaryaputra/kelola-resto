<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      max-width: 900px;
      width: 90%;
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

    .left-panel {
      background: white;
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-right: 1px solid #f0e6d2;
      box-shadow: inset -5px 0 10px rgba(0, 0, 0, 0.05);
    }

    /* tombol login gradasi ungu-biru elegan */
    .btn-login {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      color: white;
      font-weight: 600;
      border: none;
      padding: 14px;
      border-radius: 8px;
      width: 100%;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
    }

    input {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    input:focus {
      outline: none;
      border-color: #6a11cb;
      background: white;
      box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
    }

    .divider {
      text-align: center;
      position: relative;
      margin: 25px 0;
    }

    .divider::before,
    .divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #e0e0e0;
    }

    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .social-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background: white;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
      font-weight: 500;
    }

    .social-btn:hover {
      background: #f8f8f8;
      border-color: #ccc;
    }

    .social-btn img {
      width: 20px;
      height: 20px;
      margin-right: 8px;
    }

    .right-panel {
      background: url('https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=900&q=80') no-repeat center center/cover;
      position: relative;
    }

    .right-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.35);
    }

    .right-text {
      position: absolute;
      bottom: 40px;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      color: white;
      width: 80%;
    }

    .right-text h2 {
      font-size: 1.75rem;
      font-weight: 700;
    }

    .right-text p {
      font-size: 0.9rem;
      opacity: 0.85;
      margin-top: 0.5rem;
    }

  </style>
</head>

<body>

  <div class="login-container">
    <!-- Kiri: Form Login -->
    <div class="left-panel">
      <h1 class="text-3xl font-bold mb-2 text-gray-800">Masuk ke Akun Anda</h1>
      <p class="text-gray-500 mb-8 text-sm">Nikmati pengalaman kuliner terbaik hanya untuk pelanggan terdaftar.</p>

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
          <input type="email" name="email" id="email" placeholder="E-mail" required>
          @error('email')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <input type="password" name="password" id="password" placeholder="Kata sandi" required>
          @error('password')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="text-right">
          <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn-login">Login</button>
      </form>

      <div class="divider">
        <span class="bg-white px-3 text-sm text-gray-400 relative z-10">Atau</span>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <button class="social-btn">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google">
          Google
        </button>

        <button class="social-btn">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook">
          Facebook
        </button>
      </div>

      <p class="text-sm text-gray-600 mt-8 text-center">
        Belum punya akun? <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">Daftar</a>
      </p>
    </div>

    <!-- Kanan: Gambar Restoran -->
    <div class="right-panel">
      <div class="right-overlay"></div>
      <div class="right-text">
        <h2>Selamat Datang di Restoran Lezat</h2>
        <p>Rasakan suasana premium dan hidangan istimewa di tempat terbaik kami.</p>
      </div>
    </div>
  </div>

</body>
</html>
