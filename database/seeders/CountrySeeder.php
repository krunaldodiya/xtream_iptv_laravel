<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Country::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('countries.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            Country::create($item);
        });
    }
}
