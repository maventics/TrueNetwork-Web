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
        Schema::create('comissions' , function (Blueprint $table){
          $table->id();
          $table->string('user_id');
          $table->string('member_id');
          $table->string('level');
          $table->double('amount');
          $table->double('commission');
          $table->bigInteger('transaction_id');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comissions');
    }
};
