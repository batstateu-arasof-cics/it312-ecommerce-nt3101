<?php

namespace App\Contracts;

use App\Modules\Orders\Models\Order;

/**
 * Provided by: Orders team
 */
interface OrderServiceInterface
{
    /**
     * Turns the user's cart into an order and fires OrderPlaced.
     * $checkout keys: address_id, voucher_code, payment_method
     */
    public function createFromCart(int $userId, array $checkout = []): Order;

    public function find(int $orderId): ?Order;

    /** $status must be one of Order::STATUSES. */
    public function updateStatus(int $orderId, string $status): Order;

    /** True when the user has a paid, shipped or completed order containing the product. */
    public function hasPurchased(int $userId, int $productId): bool;
}
