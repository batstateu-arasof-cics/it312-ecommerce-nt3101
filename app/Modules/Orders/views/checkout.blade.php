@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Checkout</h1>

<form method="POST" action="{{ route('checkout.store') }}" class="grid md:grid-cols-3 gap-8">
    @csrf
    <div class="md:col-span-2 space-y-6">
        <section class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Shipping address</h2>
            {{-- TODO (Orders team): let the customer pick from their addresses (Users team) and send address_id --}}
            @if ($address)
                <p>{{ $address->recipient }} · {{ $address->phone }}</p>
                <p class="text-sm text-gray-600">{{ $address->fullAddress() }}</p>
            @else
                <p class="text-sm text-gray-600">No saved address yet.</p>
            @endif
        </section>

        <section class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Payment method</h2>
            <label class="flex gap-2"><input type="radio" name="payment_method" value="cod" checked> Cash on delivery</label>
            <label class="flex gap-2"><input type="radio" name="payment_method" value="online"> Pay online (GCash / card)</label>
        </section>

        <section class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Voucher</h2>
            {{-- TODO (Orders team): "Apply" button that shows the discount before placing the order --}}
            <input name="voucher_code" value="{{ old('voucher_code') }}" placeholder="Voucher code" class="border rounded px-3 py-2">
        </section>
    </div>

    <aside class="bg-white rounded shadow p-4 h-fit">
        <h2 class="font-semibold mb-3">Order summary</h2>
        <ul class="text-sm space-y-1 mb-3">
            @foreach ($items as $item)
                <li class="flex justify-between"><span>{{ $item->product->name }} × {{ $item->quantity }}</span><span>₱{{ number_format($item->lineTotal(), 2) }}</span></li>
            @endforeach
        </ul>
        <div class="border-t pt-3 text-sm space-y-1">
            <p class="flex justify-between"><span>Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></p>
            <p class="flex justify-between"><span>Shipping</span><span>₱{{ number_format($shippingFee, 2) }}</span></p>
            <p class="flex justify-between font-bold text-base"><span>Total</span><span>₱{{ number_format($subtotal + $shippingFee, 2) }}</span></p>
            <p class="text-xs text-gray-500">Voucher discount is applied when you place the order.</p>
        </div>
        <button class="w-full mt-4 bg-gray-900 text-white rounded py-2">Place order</button>
    </aside>
</form>
@endsection
