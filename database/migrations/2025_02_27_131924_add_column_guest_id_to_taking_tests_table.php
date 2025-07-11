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
        Schema::table('taking_tests', function (Blueprint $table) {
            $table->string('guest_id')->nullable()->index(); // Уникальный идентификатор для гостей
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taking_tests', function (Blueprint $table) {
            $table->dropColumn('guest_id');
        });
    }
};
