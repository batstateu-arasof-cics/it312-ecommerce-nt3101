@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-sm mx-auto bg-white rounded shadow p-6">
    <h1 class="text-xl font-bold mb-4">Login</h1>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required class="w-full border rounded px-3 py-2">
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Remember me</label>
        <button class="w-full bg-gray-900 text-white rounded py-2">Login</button>
    </form>
    {{-- TODO (Users team): "Forgot password?" link --}}
    <p class="text-sm mt-4">No account? <a href="{{ route('register') }}" class="underline">Register</a></p>
</div>
@endsection
