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
        Schema::create('risk_rewards', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('algo_session_id');

            $table
                ->foreign('algo_session_id')
                ->references('id')
                ->on('algo_sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('position_id')->nullable(false);

            $table
                ->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('symbol_name');
            $table->decimal('symbol_price', 16, 4);

            $table->decimal('sl', 10, 2);
            $table->decimal('tgt', 10, 2)->nullable();
            $table->decimal('tsl', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_rewards');
    }
};
