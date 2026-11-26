<?php

namespace App\Modules\Orders\Services;

use App\Contracts\CartServiceInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\ShippingServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Contracts\VoucherServiceInterface;
use App\Events\OrderPlaced;
use App\Modules\Orders\Models\Order;
use App\Modules\Users\Models\Address;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        private CartServiceInterface $cart,
        private UserServiceInterface $users,
        private VoucherServiceInterface $vouchers,
        private ShippingServiceInterface $shipping,
    ) {}

    public function createFromCart(int $userId, array $checkout = []): Order
    {
        $items = $this->cart->getItems($userId);

        if ($items->isEmpty()) {
            throw new RuntimeException('The cart is empty.');
        }

        // TODO (Orders team): use $checkout['address_id'] when the customer picks an address (after Users team builds the address book)
        $address = isset($checkout['address_id'])
            ? Address::where('user_id', $userId)->find($checkout['address_id'])
            : $this->users->getDefaultAddress($userId);

        $voucherCode = $checkout['voucher_code'] ?? null;
        $subtotal = $this->cart->getSubtotal($userId);
        $discount = $this->vouchers->apply($voucherCode, $subtotal);
        $shippingFee = $this->shipping->getShippingFee($address);

        $order = DB::transaction(function () use ($userId, $items, $address, $voucherCode, $subtotal, $discount, $shippingFee, $checkout) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => Order::PENDING,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'total' => $subtotal - $discount + $shippingFee,
                'voucher_code' => $discount > 0 ? $voucherCode : null,
                'payment_method' => $checkout['payment_method'] ?? 'cod',
                'address_id' => $address?->id,
                'shipping_address' => $address?->fullAddress(),
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);
            }

            $this->cart->clear($userId);

            return $order;
        });

        // Other modules react to this (stock, voucher, email, shipment)
        OrderPlaced::dispatch($order, $order->voucher_code);

        return $order;
    }

    public function find(int $orderId): ?Order
    {
        return Order::with('items')->find($orderId);
    }

    public function updateStatus(int $orderId, string $status): Order
    {
        if (! in_array($status, Order::STATUSES, true)) {
            throw new InvalidArgumentException("Unknown order status: {$status}");
        }

        $order = Order::findOrFail($orderId);

        // TODO (Orders team, Must 2): throw InvalidArgumentException when ! $order->canTransitionTo($status)
        // TODO (Orders team, Must 2): after saving, fire OrderCancelled::dispatch($order) when $status is cancelled

        $order->update(['status' => $status]);

        return $order;
    }

    public function hasPurchased(int $userId, int $productId): bool
    {
        return Order::where('user_id', $userId)
            ->whereIn('status', [Order::PAID, Order::SHIPPED, Order::COMPLETED])
            ->whereHas('items', fn ($q) => $q->where('product_id', $productId))
            ->exists();
    }
}
