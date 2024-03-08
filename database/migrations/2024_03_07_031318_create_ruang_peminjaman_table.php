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
        Schema::create('ruang_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_id');
            $table->unsignedBigInteger('ruangans_id');
            $table->timestamps();


            $table->foreign('surat_id')->references('id')->on('surat')->onDelete('cascade');
            $table->foreign('ruangans_id')->references('id')->on('ruangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_peminjaman');
    }
};
