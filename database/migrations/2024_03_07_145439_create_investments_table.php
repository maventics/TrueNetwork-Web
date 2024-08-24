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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('scheme_ref_id');
            $table->string('amount');
            $table->timestamp('end_date_timestamp')->nullable();
            $table->string('status')->default(1);//1 = running, 0 = expire/complete , 2 = claimed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
