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
        Schema::table('tb_detail_desa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_caleg')->after('id');
            $table->foreign('id_caleg')->references('id')->on('tb_caleg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_desa', function (Blueprint $table) {
            $table->dropForeign(['id_caleg']);
            $table->dropColumn('id_caleg');
        });
    }
};
