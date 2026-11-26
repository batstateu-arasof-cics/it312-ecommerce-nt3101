@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="grid md:grid-cols-2 gap-8 bg-white rounded shadow p-6">
    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full rounded">

    <div>
        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <p class="text-2xl font-bold my-3">₱{{ number_format($product->price, 2) }}</p>
        <p class="text-sm mb-4">{{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}</p>
        <p class="mb-6 whitespace-pre-line">{{ $product->description }}</p>

        {{-- Integration point: Cart team owns the cart.add route --}}
        @auth
            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex gap-2">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded px-2 py-2">
                <button class="bg-gray-900 text-white rounded px-4 py-2" @disabled($product->stock < 1)>Add to cart</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="underline">Log in to buy</a>
        @endauth
    </div>
</div>

{{-- Integration point: Reviews team provides this partial. It shows nothing until they create it. --}}
@includeIf('reviews::partials.product-reviews', ['product' => $product])
@endsection
