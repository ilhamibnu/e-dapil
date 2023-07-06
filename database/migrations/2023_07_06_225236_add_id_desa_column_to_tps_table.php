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
        Schema::table('tb_tps', function (Blueprint $table) {
            $table->unsignedBigInteger('id_desa')->after('id');
            $table->foreign('id_desa')->references('id')->on('tb_desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tps', function (Blueprint $table) {
            $table->dropForeign(['id_desa']);
            $table->dropColumn('id_desa');
        });
    }
};
