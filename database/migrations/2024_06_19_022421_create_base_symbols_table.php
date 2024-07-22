<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('base_symbols', function (Blueprint $table) {
            $table->id();

            $table->string('exchange');
            $table->string('key');
            $table->string('value');
            $table->string('type');
            $table->string('weekly_expiry_day')->nullable();
            $table->string('monthly_expiry_day')->nullable();
            $table->integer('lot_size');
            $table->integer('strike_size');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_symbols');
    }
};
