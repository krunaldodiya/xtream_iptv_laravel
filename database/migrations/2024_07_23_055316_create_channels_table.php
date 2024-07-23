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

            $table->unsignedBigInteger('category_id');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('channel_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string("stream_id");
            $table->string("channel_name");
            $table->string("channel_number");
            $table->string("channel_language")->nullable();
            $table->string("channel_country")->nullable();
            $table->enum("channel_quality", ["SD", "HD"])->default("SD");
            $table->string("channel_logo")->nullable();
            $table->string("channel_url");
            
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
