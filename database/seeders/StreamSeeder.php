<?php

namespace Database\Seeders;

use App\Models\Stream;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class StreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Stream::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('streams.json');

        $data = json_decode($content, true);

        $chunkSize = 1000;
        
        collect($data)->chunk($chunkSize)->each(function ($chunk) {
            Stream::insert($chunk->toArray());
        });
    }
}
