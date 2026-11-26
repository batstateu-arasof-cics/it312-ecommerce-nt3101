<?php

namespace App\Modules\Cart\Http\Controllers;

use App\Contracts\CartServiceInterface;
use App\Http\Controllers\Controller;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Catalog\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartServiceInterface $cart) {}

    public function index(Request $request)
    {
        $items = $this->cart->getItems($request->user()->id);
        $subtotal = $this->cart->getSubtotal($request->user()->id);

        return view('cart::index', compact('items', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);

        // TODO (Cart team): reject the request when the total quantity in the cart would exceed stock.
        // Use CatalogServiceInterface::isAvailable($product->id, $newQuantity).

        $item = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);
        $item->quantity = ($item->quantity ?? 0) + $data['quantity'];
        $item->save();

        return redirect()->route('cart.index')->with('success', $product->name.' added to cart.');
    }

    // TODO (Cart team): update(Request $request, CartItem $item)  - change quantity
    // TODO (Cart team): remove(Request $request, CartItem $item)  - delete one item
    // Both must check that $item->user_id is the logged-in user.
}
