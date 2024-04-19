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
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn(['jml_ruang', 'jml_pc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->integer('jml_ruang')->nullable()->after('nama_peminjam');
            $table->integer('jml_pc')->nullable()->after('jml_ruang');
        });
    }
};
