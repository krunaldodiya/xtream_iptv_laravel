<?php

namespace Database\Seeders;

use App\Models\Category;
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

        Category::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('categories.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            Category::create($item);
        });
    }
}
