<?php

namespace Database\Seeders;

use App\Models\AvailableBroker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AvailableBrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        AvailableBroker::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('available_brokers.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            AvailableBroker::create($item);
        });
    }
}
