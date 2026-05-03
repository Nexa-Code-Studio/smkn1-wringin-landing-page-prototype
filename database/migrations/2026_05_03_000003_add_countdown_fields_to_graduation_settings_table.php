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
        Schema::table('graduation_settings', function (Blueprint $table) {
            $table->date('tanggal_pengumuman')->nullable()->after('lulusan');
            $table->time('jam_pengumuman')->nullable()->after('tanggal_pengumuman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graduation_settings', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengumuman', 'jam_pengumuman']);
        });
    }
};
