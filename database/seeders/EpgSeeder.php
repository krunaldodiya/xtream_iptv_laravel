<?php

namespace Database\Seeders;

use App\Models\Epg;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class EpgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Epg::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('epg.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            Epg::create($item);
        });
    }
}
