@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="flex gap-8">
    <aside class="w-48 shrink-0">
        <h2 class="font-semibold mb-2">Categories</h2>
        <ul class="space-y-1 text-sm">
            @foreach ($categories as $category)
                {{-- TODO (Catalog team): link to the category page --}}
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>
    </aside>

    <section class="flex-1">
        <h1 class="text-2xl font-bold mb-6">All products</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <a href="{{ route('catalog.show', $product) }}" class="bg-white rounded shadow hover:shadow-md block">
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-t">
                    <div class="p-3">
                        <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                        <p class="font-medium">{{ $product->name }}</p>
                        <p class="font-bold">₱{{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
            @empty
                <p>No products yet.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </section>
</div>
@endsection
