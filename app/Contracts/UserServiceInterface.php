<?php

namespace App\Contracts;

use App\Models\User;
use App\Modules\Users\Models\Address;

/**
 * Provided by: Users team
 * Do not change a method signature without approval from every team that uses it.
 */
interface UserServiceInterface
{
    public function find(int $id): ?User;

    /** The logged-in user, or null for guests. */
    public function currentUser(): ?User;

    /** The user's default shipping address, or null if they have none. */
    public function getDefaultAddress(int $userId): ?Address;
}
