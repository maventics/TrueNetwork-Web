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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->string('payload')->nullable();
            $table->unsignedBigInteger('user_id')->constrain("users");//Jis ko notification sent kiya jaraa h uski ID.
            $table->integer('is_read')->default(0); // agr read krdiya h to 1 pass krna.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
