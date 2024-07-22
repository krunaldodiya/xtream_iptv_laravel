<?php

namespace Database\Seeders;

use App\Models\BaseSymbol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BaseSymbolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        BaseSymbol::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('base_symbols.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            BaseSymbol::create($item);
        });
    }
}
