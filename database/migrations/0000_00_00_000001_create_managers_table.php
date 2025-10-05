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
        Schema::create('managers', function (Blueprint $table) {
            $table->id('ID');
            $table->string('name', 128);
            $table->string('family', 128);
            $table->string('mobile', 32)->unique();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->string('password');
            $table->string('imageSID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
