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
        Schema::create('category_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('test_id');
            $table->index('category_id', 'category_test_category_idx');
            $table->index('test_id', 'category_test_test_idx');
            $table->foreign('category_id', 'category_test_category_fk')->on('categories')->references('id');
            $table->foreign('test_id', 'category_test_test_fk')->on('tests')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_tests');
    }
};
