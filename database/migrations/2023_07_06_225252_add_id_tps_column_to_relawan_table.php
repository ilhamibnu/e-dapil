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
        Schema::table('tb_relawan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tps')->after('id');
            $table->foreign('id_tps')->references('id')->on('tb_tps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relawan', function (Blueprint $table) {
            $table->dropForeign(['id_tps']);
            $table->dropColumn('id_tps');
        });
    }
};
