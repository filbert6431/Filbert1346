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
Schema::table('pelanggan', function (Blueprint $table) {
            // Mengubah kolom 'gender' dengan daftar ENUM baru
            // 'change()' harus dipanggil agar migrasi diterapkan.
            $table->enum('gender', ['Male', 'Female', 'Other', 'Prefer Not To Say'])
                  ->nullable()
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
   Schema::table('pelanggan', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female', 'Other'])
                  ->nullable()
                  ->change();
        });
    }
};
