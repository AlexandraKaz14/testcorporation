<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users ADD CONSTRAINT allowed_status_types
  CHECK (status IN (
    'active',
    'blocked'
  ));");
        DB::statement("ALTER TABLE users ADD CONSTRAINT allowed_role_types
  CHECK (role IN (
    'moderator',
    'admin',
     'author'
  ));");




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users DROP CONSTRAINT allowed_status_types;");
        DB::statement("ALTER TABLE users DROP CONSTRAINT allowed_role_types;");

    }
};
