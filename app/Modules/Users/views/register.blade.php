@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-sm mx-auto bg-white rounded shadow p-6">
    <h1 class="text-xl font-bold mb-4">Create an account</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1">Name</label>
            <input name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm mb-1">Confirm password</label>
            <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
        </div>
        <button class="w-full bg-gray-900 text-white rounded py-2">Register</button>
    </form>
</div>
@endsection
