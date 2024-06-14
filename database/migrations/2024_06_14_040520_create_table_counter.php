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
        // Schema::table("nama_table", callback(){definisikan column di sini}) // alter table column
        // Schema::create("nama_table", callback(){definisikan column di sini}) // Schema::create // membuat table baru
        Schema::create('counters', function (Blueprint $table) {
            $table->string('id', 100)->nullable(false)->primary();
            $table->integer('counter')->nullable(false)->default(0);
        });
    }

    /**
     * down(): void // itu Roolback create table
     * // di sini apa yang mau kita BATALKAN
     */
    public function down(): void
    {
        Schema::dropIfExists('table_counter');
    }
};
