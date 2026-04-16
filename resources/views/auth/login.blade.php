<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Self Ordering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen flex items-center justify-center p-4">

<div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-utensils text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Self Ordering System</h1>
        <p class="text-gray-400 text-sm mt-1">Masuk untuk mengakses sistem</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                       placeholder="admin@selforder.com" required autofocus>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="password" name="password"
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                       placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-colors">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk
        </button>
    </form>
</div>

</body>
</html>
