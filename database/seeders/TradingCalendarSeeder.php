<?php

namespace Database\Seeders;

use App\Models\TradingCalendar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class TradingCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        TradingCalendar::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('trading_calendar.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            TradingCalendar::create($item);
        });
    }
}
