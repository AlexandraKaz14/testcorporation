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
            $table->boolean('is_temporary')->default(false)->after('generated_picture_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taking_tests', function (Blueprint $table) {
            $table->dropColumn('is_temporary');
        });
    }
};
