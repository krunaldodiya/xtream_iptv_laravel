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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('xtream_account_id');

            $table
                ->foreign('xtream_account_id')
                ->references('id')
                ->on('xtream_accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('category_id');

            $table->string("stream_id");

            $table->string("name");

            $table->text("logo")->nullable();

            $table->text('url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};
