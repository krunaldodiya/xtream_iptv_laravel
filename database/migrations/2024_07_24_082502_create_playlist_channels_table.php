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
        Schema::create('playlist_channels', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('playlist_id');

            $table
                ->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('category_id');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string("name");
            $table->string("number");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_channels');
    }
};
