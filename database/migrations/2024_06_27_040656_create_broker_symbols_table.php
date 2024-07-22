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
        Schema::create('broker_symbols', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('base_symbol_id');

            $table
                ->foreign('base_symbol_id')
                ->references('id')
                ->on('base_symbols')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('broker_title');
            $table->string('exchange');

            $table->enum('market_type', ['Cash', 'Derivative'])->default('Cash');
            $table->enum('segment_type', ['Equity', 'Future', 'Option'])->default('Equity');

            $table->date('expiry_date')->nullable();
            $table->enum('expiry_period', ['Weekly', 'Monthly'])->nullable();
            $table->decimal('strike_price', 16, 4)->nullable();
            $table->enum('option_type', ['CE', 'PE'])->nullable();

            $table->string('symbol_name');
            $table->string('symbol_token');
            $table->bigInteger('exchange_token');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broker_symbols');
    }
};
