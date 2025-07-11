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
        Schema::create('result_variable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variable_id');
            $table->unsignedBigInteger('result_id');
            $table->index('variable_id', 'variable_result_variable_idx');
            $table->index('result_id', 'variable_result_result_idx');
            $table->foreign('variable_id', 'variable_result_variable_fk')->on('variables')->references('id');
            $table->foreign('result_id', 'variable_result_result_fk')->on('results')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_variable');
    }
};
