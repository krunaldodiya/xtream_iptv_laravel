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
        Schema::create('channel_playlist', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('playlist_id');

            $table
                ->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('channel_id');

            $table
                ->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->timestamps();

            $table->unique(['playlist_id', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_playlist');
    }
};
