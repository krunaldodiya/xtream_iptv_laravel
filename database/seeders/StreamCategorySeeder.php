<?php

namespace Database\Seeders;

use App\Models\StreamCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class StreamCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        StreamCategory::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('stream_categories.json');

        $data = json_decode($content, true);

        $chunkSize = 1000;
        
        collect($data)->chunk($chunkSize)->each(function ($chunk) {
            StreamCategory::insert($chunk->toArray());
        });
    }
}
