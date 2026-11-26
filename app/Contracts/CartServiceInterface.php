<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Provided by: Cart team
 */
interface CartServiceInterface
{
    /** Cart items of the user, each with its ->product loaded. */
    public function getItems(int $userId): Collection;

    /** Sum of quantity x product price, before discount and shipping. */
    public function getSubtotal(int $userId): float;

    /** Empties the cart. Called by Orders team after an order is placed. */
    public function clear(int $userId): void;
}
