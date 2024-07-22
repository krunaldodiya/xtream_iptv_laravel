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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('broker_id');

            $table
                ->foreign('broker_id')
                ->references('id')
                ->on('brokers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('data_broker_id');

            $table
                ->foreign('data_broker_id')
                ->references('id')
                ->on('brokers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('github_repository_id');

            $table
                ->foreign('github_repository_id')
                ->references('id')
                ->on('github_repositories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->enum('status', ["Active", "Inactive"])->default("Active");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
