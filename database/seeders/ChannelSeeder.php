<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Channel::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('channels.json');

        $data = json_decode($content, true);

        $chunkSize = 1000;
        
        collect($data)->chunk($chunkSize)->each(function ($chunk) {
            Channel::insert($chunk->toArray());
        });
    }
}
