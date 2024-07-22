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
        Schema::create('orders', function (Blueprint $table) {
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

            $table->unsignedBigInteger('broker_symbol_id');

            $table
                ->foreign('broker_symbol_id')
                ->references('id')
                ->on('broker_symbols')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->uuid('order_id')->nullable(false)->index();
            $table->uuid('position_id')->nullable()->index();

            $table->enum('position_type', ['BUY', 'SELL']);
            $table->enum('order_type', ['LIMIT_ORDER', 'MARKET_ORDER', 'STOP_ORDER', 'STOP_LIMIT_ORDER']);
            $table->enum('product_type', ['MIS', 'NRML', 'CNC']);

            $table->integer('quantities');
            $table->decimal('price', 16, 4);
            $table->enum('status', ['pending', 'created', 'completed', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
