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
        Schema::create('transaction_tables', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('type');
            $table->string('avaiable_amount');
            $table->string('status')->default(0);
            $table->unsignedBigInteger('deposit_id')->constrain('depositrequests')->default(0);
            $table->unsignedBigInteger('withdraw_id')->constrain('withdrawrequests')->default(0);
            $table->unsignedBigInteger('investment_id')->constrain('investments')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_tables');
    }
};
