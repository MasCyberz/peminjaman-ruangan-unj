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
        Schema::table('ruang_peminjaman', function (Blueprint $table) {
            $table->date('tanggal_peminjaman')->after('ruangans_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruang_peminjaman', function (Blueprint $table) {
            $table->dropColumn('tanggal_peminjaman');
        });
    }
};
