<?php

namespace Database\Seeders;

use App\Models\XtreamAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class XtreamAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        XtreamAccount::truncate();

        Schema::enableForeignKeyConstraints();

        $content = Storage::disk('seeds')->get('xtream_accounts.json');

        $data = json_decode($content, true);

        collect($data)->each(function ($item) {
            XtreamAccount::create($item);
        });
    }
}
