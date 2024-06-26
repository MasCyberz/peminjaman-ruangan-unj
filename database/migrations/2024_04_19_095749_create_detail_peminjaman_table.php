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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_id');
            $table->date('tanggal_peminjaman');
            $table->integer('jml_pc');
            $table->integer('jml_ruang');
            $table->timestamps();

            $table->foreign('surat_id')->references('id')->on('surat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
