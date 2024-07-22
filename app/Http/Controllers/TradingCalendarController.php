<?php

namespace App\Http\Controllers;

use App\Models\TradingCalendar;
use Illuminate\Http\Request;

class TradingCalendarController extends Controller
{
    public function get_holidays(Request $request)
    {
        $holidays = TradingCalendar::query()
            ->whereNot('description', 'Market Open')
            ->whereNot('description', 'Weekend')
            ->get();

        return response()->json(['holidays' => $holidays]);
    }

    public function get_trading_days(Request $request)
    {
        $trading_days = TradingCalendar::query()
            ->where('description', 'Market Open')
            ->get();

        return response()->json(['trading_days' => $trading_days]);
    }
}
