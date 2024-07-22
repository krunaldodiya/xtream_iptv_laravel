<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\AlgoSession;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function get_orders(Request $request)
    {
        $algo_session = AlgoSession::query()->where(['key' => $request->algo_session_key])->first();

        $orders = Order::query()
            ->with(['broker_symbol.base_symbol'])
            ->where('algo_session_id', $algo_session->id)
            ->where('user_id', $algo_session->user_id)
            ->where('created_at', '>=', now()->today())
            ->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function create_order(CreateOrderRequest $request)
    {
        $data = $request->all();

        $order = Order::create([...$data, 'user_id' => auth()->id()]);

        $order->load("broker_symbol.base_symbol");

        return response()->json(['order' => $order]);
    }
}
