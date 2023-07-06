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
        Schema::table('tb_detail_relawan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_relawan')->after('id');
            $table->foreign('id_relawan')->references('id')->on('tb_relawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_relawan', function (Blueprint $table) {
            $table->dropForeign(['id_relawan']);
            $table->dropColumn('id_relawan');
        });
    }
};
