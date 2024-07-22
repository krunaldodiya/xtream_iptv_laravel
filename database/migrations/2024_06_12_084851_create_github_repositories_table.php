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
        Schema::create('github_repositories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('github_account_id');

            $table
                ->foreign('github_account_id')
                ->references('id')
                ->on('github_accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('repository_id');
            $table->string('repository_owner');
            $table->string('repository_name');
            $table->string('repository_full_name');
            $table->string('repository_ssh_url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_repositories');
    }
};
