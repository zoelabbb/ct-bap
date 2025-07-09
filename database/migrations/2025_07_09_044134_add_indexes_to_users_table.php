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
            // Index untuk kolom name (sering digunakan untuk search)
            $table->index('name', 'idx_users_name');

            // Index untuk kolom created_at (untuk ordering)
            $table->index('created_at', 'idx_users_created_at');

            // Composite index untuk kombinasi search + ordering
            $table->index(['name', 'created_at'], 'idx_users_name_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_name');
            $table->dropIndex('idx_users_created_at');
            $table->dropIndex('idx_users_name_created_at');
        });
    }
};
