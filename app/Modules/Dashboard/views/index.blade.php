@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Admin dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Total sales</p>
        <p class="text-2xl font-bold">₱{{ number_format($summary['total_sales'], 2) }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-sm text-gray-500">Orders</p>
        <p class="text-2xl font-bold">{{ $summary['order_count'] }}</p>
    </div>
    {{-- TODO (Dashboard team): orders by status, average order value --}}
</div>

<div class="grid md:grid-cols-2 gap-6">
    <section class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-2">Low stock</h2>
        @forelse ($lowStock as $product)
            <p class="text-sm">{{ $product->name }} — {{ $product->stock }} left</p>
        @empty
            <p class="text-sm text-gray-500">No low-stock products.</p>
        @endforelse
    </section>
    <section class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-2">Top products</h2>
        {{-- TODO (Dashboard team): top 5 products by quantity sold --}}
        <p class="text-sm text-gray-500">Not built yet.</p>
    </section>
</div>

{{-- TODO (Dashboard team): links to admin pages of other teams (products, orders, inventory, vouchers, reviews) as they are merged --}}
@endsection
