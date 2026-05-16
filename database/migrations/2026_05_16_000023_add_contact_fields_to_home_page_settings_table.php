<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('mitra_industri');
            $table->string('nomor_telepon', 50)->nullable()->after('alamat');
            $table->string('email', 120)->nullable()->after('nomor_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'nomor_telepon', 'email']);
        });
    }
};
