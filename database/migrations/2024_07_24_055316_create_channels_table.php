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
        
            $table->unsignedBigInteger('language_id');

            $table
                ->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('country_id');

            $table
                ->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('category_id');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('stream_id');

            $table
                ->foreign('stream_id')
                ->references('id')
                ->on('streams')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string("name");

            $table->text("logo")->nullable();

            $table->text("number")->nullable();

            $table->text("epg")->nullable();
            
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
