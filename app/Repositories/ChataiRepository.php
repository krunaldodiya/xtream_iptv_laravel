<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChataiRepository implements ChataiRepositoryInterface
{
    public function process($name, $email, $password)
    {
        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            return $user;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}