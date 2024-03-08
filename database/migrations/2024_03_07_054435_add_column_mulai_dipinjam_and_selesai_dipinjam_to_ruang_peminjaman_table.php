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
            $table->date('mulai_dipinjam')->after('ruangans_id');
            $table->date('selesai_dipinjam')->after('mulai_dipinjam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruang_peminjaman', function (Blueprint $table) {
            $table->dropColumn('mulai_dipinjam');
            $table->dropColumn('selesai_dipinjam');
        });
    }
};
