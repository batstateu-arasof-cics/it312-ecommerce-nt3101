{{-- Shared layout (instructor-owned). Every module view uses @extends('layouts.app'). --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop') · {{ config('app.name') }}</title>
    {{-- Tailwind via CDN so no build step is needed in class --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center gap-6">
            <a href="{{ route('catalog.index') }}" class="font-bold text-lg">{{ config('app.name') }}</a>
            <a href="{{ route('catalog.index') }}" class="text-sm hover:underline">Shop</a>
            <a href="{{ route('search.index') }}" class="text-sm hover:underline">Search</a>

            <div class="ml-auto flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('cart.index') }}" class="hover:underline">Cart</a>
                    <a href="{{ route('orders.index') }}" class="hover:underline">My Orders</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:underline font-semibold">Admin</a>
                    @endif
                    <span class="text-gray-500">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl w-full mx-auto px-4 py-8 flex-1">
        @if (session('success'))
            <div class="mb-6 rounded bg-green-100 text-green-800 px-4 py-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded bg-red-100 text-red-800 px-4 py-3">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded bg-red-100 text-red-800 px-4 py-3">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-xs text-gray-400 py-6">IT 312 System Integration and Architecture · Class project</footer>
</body>
</html>
