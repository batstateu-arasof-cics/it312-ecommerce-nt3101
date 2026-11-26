<?php

namespace App\Modules\Orders\Http\Controllers;

use App\Contracts\CartServiceInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\PaymentServiceInterface;
use App\Contracts\ShippingServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(
        Request $request,
        CartServiceInterface $cart,
        UserServiceInterface $users,
        ShippingServiceInterface $shipping,
    ) {
        $userId = $request->user()->id;
        $items = $cart->getItems($userId);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $address = $users->getDefaultAddress($userId);
        $subtotal = $cart->getSubtotal($userId);
        $shippingFee = $shipping->getShippingFee($address);

        return view('orders::checkout', compact('items', 'address', 'subtotal', 'shippingFee'));
    }

    public function store(Request $request, OrderServiceInterface $orders, PaymentServiceInterface $payments)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:cod,online'],
            'voucher_code' => ['nullable', 'string', 'max:50'],
        ]);

        // TODO (Orders team): re-check stock for every item before creating the order (CatalogServiceInterface::isAvailable)

        $order = $orders->createFromCart($request->user()->id, $data);
        $payment = $payments->createPayment($order, $data['payment_method']);

        if ($payment->checkout_url) {
            return redirect()->away($payment->checkout_url); // online payment (Payments team)
        }

        return redirect()->route('orders.index')->with('success', 'Order '.$order->number().' placed.');
    }
}
