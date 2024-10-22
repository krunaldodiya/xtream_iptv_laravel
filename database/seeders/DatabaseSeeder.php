<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            XtreamAccountSeeder::class,
            EpgSeeder::class,
            CategorySeeder::class,
            LanguageSeeder::class,
            CountrySeeder::class,
            StreamCategorySeeder::class,
            StreamSeeder::class,
        ]);
    }
}
