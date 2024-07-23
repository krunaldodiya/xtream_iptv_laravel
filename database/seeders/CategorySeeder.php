<?php

namespace Database\Seeders;

use App\Models\ChannelCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        ChannelCategory::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('channel_categories.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            ChannelCategory::create($item);
        });
    }
}
