{{-- Included by Catalog team's product page: @includeIf('reviews::partials.product-reviews', ['product' => $product]) --}}
@php
    $reviews = \App\Modules\Reviews\Models\Review::with('user')
        ->where('product_id', $product->id)
        ->where('is_approved', true)
        ->latest()
        ->get();
    $average = app(\App\Contracts\ReviewServiceInterface::class)->getAverageRating($product->id);
@endphp

<section class="bg-white rounded shadow p-6 mt-8">
    <h2 class="text-lg font-semibold mb-1">Reviews</h2>
    <p class="text-sm text-gray-600 mb-4">
        {{ $average ? $average.' / 5 from '.$reviews->count().' review(s)' : 'No reviews yet.' }}
    </p>

    {{-- TODO (Reviews team): review form, shown only when OrderServiceInterface::hasPurchased() is true
         and the customer has not reviewed this product yet --}}

    @foreach ($reviews as $review)
        <div class="border-t py-3">
            <p class="text-sm"><strong>{{ $review->user->name }}</strong> · {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
            <p class="text-sm text-gray-700">{{ $review->comment }}</p>
        </div>
    @endforeach
</section>
