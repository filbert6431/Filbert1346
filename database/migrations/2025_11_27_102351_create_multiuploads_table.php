<?php
// database/migrations/2024_01_01_000000_update_multiuploads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus tabel jika sudah ada (untuk development)
        Schema::dropIfExists('multiuploads');

        // Buat tabel baru dengan struktur yang benar
        Schema::create('multiuploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('ref_table', 100);
            $table->unsignedBigInteger('ref_id');
            $table->timestamps();

            // Index untuk performa query
            $table->index(['ref_table', 'ref_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('multiuploads');
    }
};
