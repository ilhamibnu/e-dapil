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
        Schema::table('tb_desa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kecamatan')->after('name');
            $table->foreign('id_kecamatan')->references('id')->on('tb_kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_desa', function (Blueprint $table) {
            $table->dropForeign(['id_kecamatan']);
            $table->dropColumn('id_kecamatan');
        });
    }
};
