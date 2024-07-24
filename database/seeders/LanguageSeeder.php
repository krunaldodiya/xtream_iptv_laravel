<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Language::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('languages.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            Language::create($item);
        });
    }
}
