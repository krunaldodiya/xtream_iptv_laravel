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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id')->nullable();

            $table
                ->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        
            $table->unsignedBigInteger('language_id')->nullable();

            $table
                ->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('category_id')->nullable();

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('stream_id')->nullable();

            $table
                ->foreign('stream_id')
                ->references('id')
                ->on('streams')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('epg_id')->nullable();

            $table
                ->foreign('epg_id')
                ->references('id')
                ->on('epgs')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');

            $table->string("name");

            $table->text("logo")->nullable();

            $table->text("number")->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
