<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Models\Category;
use App\Modules\Catalog\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::active()->with('category')->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('catalog::index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('catalog::show', compact('product'));
    }

    // TODO (Catalog team): category page, e.g. category(Category $category)
}
