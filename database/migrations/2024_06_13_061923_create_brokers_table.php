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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('available_broker_id');

            $table
                ->foreign('available_broker_id')
                ->references('id')
                ->on('available_brokers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('broker_uid');
            $table->string('broker_title');
            $table->string('broker_name');
            $table->json('broker_config');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
