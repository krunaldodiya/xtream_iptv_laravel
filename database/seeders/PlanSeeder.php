<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Plan::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('plans.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            Plan::create($item);
        });
    }
}
