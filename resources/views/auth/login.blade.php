<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Restaurant</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-sm bg-white shadow-md rounded-xl p-8 border border-gray-200">

        <h1 class="text-center text-2xl font-semibold text-gray-800 mb-6">
            Login
        </h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    type="email" id="email" name="email" required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-600 focus:outline-none"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" id="password" name="password" required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-600 focus:outline-none"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button 
                type="submit"
                class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-black transition font-medium">
                Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            © {{ date('Y') }} Restaurant System
        </p>
    </div>

</body>
</html>
