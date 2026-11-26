<?php

namespace App\Modules\Users\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use App\Modules\Users\Models\Address;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function currentUser(): ?User
    {
        return Auth::user();
    }

    public function getDefaultAddress(int $userId): ?Address
    {
        // TODO (Users team): return the address marked is_default.
        // If none is marked, return the most recently added address.
        // Until this is done, checkout runs without an address and Shipping team charges the default rate.
        return null;
    }
}
