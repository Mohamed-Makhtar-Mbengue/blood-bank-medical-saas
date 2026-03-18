<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-gray-800 p-8 rounded-xl shadow-xl">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-20 h-20 rounded-full bg-red-600 flex items-center justify-center shadow-xl">
                <span class="text-white text-4xl font-bold">🩸</span>
            </div>
            <h1 class="text-2xl font-bold text-red-400 mt-4 tracking-wide">
                BLOOD BANK
            </h1>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-300 mb-1">Email</label>
                <input type="email" name="email" id="email"
                       class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:border-red-500 focus:ring-red-500"
                       required autofocus>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-300 mb-1">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:border-red-500 focus:ring-red-500"
                       required>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-600 bg-gray-800 text-red-600 focus:ring-red-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-400">Remember me</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 rounded-lg font-semibold">
                Log in
            </button>
        </form>

    </div>

</body>
</html>
