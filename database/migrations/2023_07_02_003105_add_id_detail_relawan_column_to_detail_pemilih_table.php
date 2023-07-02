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
        Schema::table('tb_detail_pemilih', function (Blueprint $table) {
            $table->unsignedBigInteger('id_detail_relawan')->after('id');
            $table->foreign('id_detail_relawan')->references('id')->on('tb_detail_relawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_pemilih', function (Blueprint $table) {
            $table->dropForeign(['id_detail_relawan']);
            $table->dropColumn('id_detail_relawan');
        });
    }
};
