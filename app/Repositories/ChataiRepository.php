<?php

namespace App\Repositories;

use App\Models\User;

class ChataiRepository implements ChataiRepositoryInterface
{
    public function process()
    {
        try {
            $firstUser = User::orderBy('created_at', 'asc')->first();
            return $firstUser->name;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

interface ChataiRepositoryInterface
{
    public function process();
}