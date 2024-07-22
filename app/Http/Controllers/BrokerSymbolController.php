<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBrokerSymbolInfoRequest;
use App\Http\Requests\BrokerSymbolInfoRequest;
use App\Models\BrokerSymbol;
use Illuminate\Http\Request;

class BrokerSymbolController extends Controller
{
    public function get_symbol_info(BrokerSymbolInfoRequest $request)
    {
        $data = $request->all();

        $broker_symbol = BrokerSymbol::query()
            ->with(['base_symbol'])
            ->where([
                "base_symbol_id" => $data['base_symbol_id'],
                "exchange" => $data['exchange'],
                "market_type" => $data['market_type'],
                "segment_type" => $data['segment_type'],
                "broker_title" => $request->route('broker_title')
            ])
            ->where(function ($query) use ($data) {
                foreach (['expiry_date', 'expiry_period', 'strike_price', 'option_type'] as $field) {
                    if ($data[$field]) {
                        $query->where($field, $data[$field]);
                    }
                }
            })
            ->first();

        return response()->json(['broker_symbol' => $broker_symbol]);
    }

    public function add_symbol_info(AddBrokerSymbolInfoRequest $request)
    {
        $data = $request->all();

        $broker_symbol = BrokerSymbol::query()
            ->where([
                "base_symbol_id" => $data['base_symbol_id'],
                "exchange" => $data['exchange'],
                "market_type" => $data['market_type'],
                "segment_type" => $data['segment_type'],
                "broker_title" => $request->route('broker_title')
            ])
            ->where(function ($query) use ($data) {
                foreach (['expiry_date', 'expiry_period', 'strike_price', 'option_type'] as $field) {
                    if ($data[$field]) {
                        $query->where($field, $data[$field]);
                    }
                }
            })
            ->first();

        if (!$broker_symbol) {
            $broker_symbol = BrokerSymbol::create([...$data, 'broker_title' => $request->route('broker_title')]);
        }

        $broker_symbol->load("base_symbol");

        return response()->json(['broker_symbol' => $broker_symbol]);
    }
}
