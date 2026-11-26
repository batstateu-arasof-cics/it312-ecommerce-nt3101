@extends('layouts.app')

@section('title', 'Search')

@section('content')
<form method="GET" action="{{ route('search.index') }}" class="flex gap-2 mb-6">
    <input name="q" value="{{ $query }}" placeholder="Search products" class="flex-1 border rounded px-3 py-2">
    {{-- TODO (Search team): category, price range, rating and sort inputs --}}
    <button class="bg-gray-900 text-white rounded px-4">Search</button>
</form>

<p class="text-sm text-gray-500 mb-4">{{ $products->total() }} result(s){{ $query !== '' ? ' for "'.$query.'"' : '' }}</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    @foreach ($products as $product)
        <a href="{{ route('catalog.show', $product) }}" class="bg-white rounded shadow hover:shadow-md block p-3">
            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
            <p class="font-medium">{{ $product->name }}</p>
            <p class="font-bold">₱{{ number_format($product->price, 2) }}</p>
        </a>
    @endforeach
</div>
<div class="mt-6">{{ $products->links() }}</div>
@endsection
