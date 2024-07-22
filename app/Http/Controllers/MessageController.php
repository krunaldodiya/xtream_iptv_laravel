<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        return inertia('Message/Create');
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'message' => $request->message,
            'user_id' => $request->user()->id
        ]);

        MessageCreated::broadcast($message);
    }
}
