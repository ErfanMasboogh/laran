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
        Schema::create('storage', function (Blueprint $table) {
            $table->string('SID')->primary();
            $table->unsignedBigInteger('userID')->index();
            $table->string('storable_type', 128)->nullable();
            $table->unsignedBigInteger('storable_id')->nullable();
            $table->string('fileType', 64);
            $table->string('fileName', 128);
            $table->string('fileExtension', 32);
            $table->unsignedBigInteger('fileSize');
            $table->boolean('isUsed')->default(false);
            $table->boolean('isPublic')->default(false);
            $table->bigInteger('created');
            $table->bigInteger('updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage');
    }
};
