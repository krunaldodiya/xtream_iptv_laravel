<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class ChataiRepository implements ChataiRepositoryInterface
{
    public function process(): int
    {
        return User::count();
    }
}