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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->text("description");
            $table->integer("maximum_projects");
            $table->boolean("can_paper_trade");
            $table->boolean("can_live_trade");
            $table->decimal("monthly_charges", 16, 4);
            $table->string("currency");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
