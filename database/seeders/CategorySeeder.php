<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("categories")->insert([
            "id" => "SANDAL",
            "name" => "Sandal",
            "description" => "",
            "created_at" => "2024-06-13 10:10:10"
        ]);
        DB::table("categories")->insert([
            "id" => "JAKET",
            "name" => "Jaket",
            "description" => "",
            "created_at" => "2024-06-13 10:10:10"
        ]);
        DB::table("categories")->insert([
            "id" => "TOPI",
            "name" => "Topi",
            "description" => "",
            "created_at" => "2024-06-13 10:10:10"
        ]);
        DB::table("categories")->insert([
            "id" => "CELANA",
            "name" => "Celana",
            "description" => "",
            "created_at" => "2024-06-13 10:10:10"
        ]);
    }
}
