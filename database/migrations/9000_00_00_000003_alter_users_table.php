<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'ID');
            $table->string('name')->nullable()->change();
            $table->string('family')->nullable()->after('name');
            $table->string('mobile')->unique()->after('family');
            $table->string('email')->nullable()->change();
            $table->dropTimestamps();
            $table->unsignedBigInteger('created');
            $table->unsignedBigInteger('updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('ID', 'id');
            $table->string('name')->nullable(false)->change();
            $table->dropColumn(['family', 'mobile']);
            $table->string('email')->nullable(false)->change();
            $table->dropColumn(['created', 'updated']);
            $table->timestamps();
        });
    }
};