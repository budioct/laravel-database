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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 100)->nullable(false)->primary();
            $table->string('name', 100)->nullable(false);
            $table->text('description')->nullable(true);
            $table->integer('price')->nullable(false);
            $table->string('category_id', 100)->nullable(false); // foreign key (FK)
            $table->timestamp('created_at')->nullable(false)->useCurrent();

            // beri tahu category_id adalah foreign key (FK) pada table products ini
            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * down(): void // itu Roolback create table
     * // di sini apa yang mau kita BATALKAN
     */
    public function down(): void
    {
        Schema::dropIfExists('table_category');
    }
};
