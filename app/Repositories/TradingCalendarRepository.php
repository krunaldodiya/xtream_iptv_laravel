<?php

namespace App\Repositories;

use App\Models\TradingCalendar;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TradingCalendarRepository implements TradingCalendarRepositoryInterface
{
    public function fetch_calendar()
    {
        Log::info('Processing date', ['date' => '2024-06-20']);

        $response = Http::get('https://api.upstox.com/v2/market/holidays');

        $holidays = collect($response['data'])->keyBy('date');

        $startYear = now()->startOfYear();
        $endYear = now()->endOfYear();

        $period = CarbonPeriod::create($startYear, $endYear);

        collect($period)->each(function ($date) use ($holidays) {
            $this->update_or_create_trading_calendar($date, $holidays);
        });
    }

    private function update_or_create_trading_calendar($date, $holidays)
    {
        $dateString = $date->format('Y-m-d');

        if ($holidays->has($dateString)) {
            $holiday = $holidays->get($dateString);
            $description = $holiday['description'];
            $closedExchanges = $holiday['closed_exchanges'];
        } elseif ($date->isWeekend()) {
            $description = "Weekend";
            $closedExchanges = ["NSE", "NFO", "BSE", "BFO", "CDS", "BCD", "MCX"];
        } else {
            $description = "Market Open";
            $closedExchanges = [];
        }

        TradingCalendar::updateOrCreate(
            [
                "date" => $date,
            ],
            [
                "closed_exchanges" => $closedExchanges,
                "description" => $description,
            ]
        );
    }
}
