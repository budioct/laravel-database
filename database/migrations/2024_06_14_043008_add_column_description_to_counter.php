<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * note: method up() dan down() ANTOMIN = BERLAWANAN
     */

    /**
     * up(): void // itu begin create table
     * // di sini apa yang mau kita LAKUKAN
     */
    public function up(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->text('description')->nullable(true);
        });
    }

    /**
     * down(): void // itu Roolback create table
     * // di sini apa yang mau kita BATALKAN
     */
    public function down(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn("description");
        });
    }
};
