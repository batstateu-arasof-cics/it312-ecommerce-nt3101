@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<h1 class="text-2xl font-bold mb-6">Your cart</h1>

@if ($items->isEmpty())
    <p>Your cart is empty. <a href="{{ route('catalog.index') }}" class="underline">Continue shopping</a></p>
@else
    <table class="w-full bg-white rounded shadow text-sm">
        <thead class="text-left border-b">
            <tr><th class="p-3">Product</th><th class="p-3">Price</th><th class="p-3">Qty</th><th class="p-3 text-right">Total</th><th></th></tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr class="border-b">
                    <td class="p-3">{{ $item->product->name }}</td>
                    <td class="p-3">₱{{ number_format($item->product->price, 2) }}</td>
                    {{-- TODO (Cart team): quantity input that submits to cart.update --}}
                    <td class="p-3">{{ $item->quantity }}</td>
                    <td class="p-3 text-right">₱{{ number_format($item->lineTotal(), 2) }}</td>
                    {{-- TODO (Cart team): remove button that submits to cart.remove --}}
                    <td class="p-3"></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6 flex justify-end items-center gap-6">
        <p class="text-lg">Subtotal: <strong>₱{{ number_format($subtotal, 2) }}</strong></p>
        {{-- Integration point: Orders team owns the checkout.show route --}}
        <a href="{{ route('checkout.show') }}" class="bg-gray-900 text-white rounded px-4 py-2">Checkout</a>
    </div>
@endif
@endsection
