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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 255)->required();
            $table->string('asal_surat', 255)->required();
            $table->string('nama_peminjam', 255)->required();
            $table->date('mulai_dipinjam')->required();
            $table->date('selesai_dipinjam')->required();
            $table->integer('jml_ruang')->required();
            $table->integer('jml_pc')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
