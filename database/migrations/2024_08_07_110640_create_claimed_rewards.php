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
        Schema::create('claimed_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constraint('users')->nullable();
            $table->unsignedBigInteger('reward_id')->constraint('rewards')->nullable();
            $table->bigInteger('last_deposit')->nullable();
            $table->integer('status')->default(1)->nullable();//1 means available to claim. 0 means already claimed.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claimed_rewards');
    }
};
