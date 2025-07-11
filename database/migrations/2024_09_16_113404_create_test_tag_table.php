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
        Schema::create('tag_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('tag_id');
            $table->index('test_id', 'test_tag_test_idx');
            $table->index('tag_id', 'test_tag_tag_idx');
            $table->foreign('test_id', 'test_tag_test_fk')->on('tests')->references('id');
            $table->foreign('tag_id', 'test_tag_tag_fk')->on('tags')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_tests');
    }
};
