<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseMigrationTest extends TestCase
{

    /**
     * Database Migration
     * ● Sebelumnya ketika membuat tabel, kita melakukannya secara manual ke MySQL
     * ● Laravel memiliki fitur bernama Database Migration
     * ● Fitur ini digunakan untuk melakukan versioning schema database, dimana setiap perubahan akan
     *   di track sehingga akan selalu konsisten
     * ● Dengan menggunakan Database Migration, kita tidak perlu mengubah Schema Database secara
     *   manual lagi
     *
     * Membuat Database Migration
     * ● Untuk membuat file Database Migration baru, kita bisa menggunakan perintah :
     *   php artisan make:migration nama_file_migration
     * ● Secara otomatis akan dibuatkan file PHP yang digunakan untuk melakukan perubahan schema di
     *   database di folder database/migrations
     * ● Untuk membuat perubahan schema, kita bisa menggunakan Schema Builder, tidak perlu manual
     *   menggunakan SQL lagi
     * ● https://laravel.com/api/10.x/Illuminate/Support/Facades/Schema.html
     * ● https://laravel.com/api/10.x/Illuminate/Database/Schema/Blueprint.html
     *
     * note:
     * php artisan make:migration create_table_counter
     * INFO  Migration [C:\Dev\2024\Laravel\laravel-database\database\migrations/2024_06_14_040520_create_table_counter.php] created successfully.
     * biasanya hasil file migration akan di awali dengan waktu agar selalu queue saat kita membuatnya
     *
     * Tipe Data di Migrations
     * ● Laravel mendukung banyak tipe data di Migrations
     * ● Kita bisa liat di halaman dokumentasinya
     * ● https://laravel.com/docs/10.x/migrations#available-column-types
     *
     * Menjalankan Database Migration
     * ● Setelah file database migration selesai dibuat, selanjutnya kita bisa menjalankan file migration
     *   tersebut
     * ● Untuk melihat status migration : php artisan migrate:status
     * ● Untuk menjalankan migration : php artisan migrate
     * ● Setelah migration dijalankan, status file mana yang pernah dijalankan akan disimpan di tabel
     *   migrations
     * ● Jika kita mengubah file lama yang sudah dijalankan, maka tidak ada gunanya, karena tidak akan
     *   pernah dijalankan lagi
     * ● Jika mau melakukan perubahan, silahkan buat migration file baru untuk melakukan perubahannya
     *
     * note:
     * ❯ php artisan migrate:status
     * ERROR  Migration table not found. // artinya kita belum menjalankan migration sebelumnya
     *
     * ❯ php artisan migrate
     * INFO  Preparing database.
     * Creating migration table .............................................................................................................. 182ms DONE
     * INFO  Running migrations.
     * 2014_10_12_000000_create_users_table .................................................................................................. 166ms DONE
     * 2014_10_12_100000_create_password_reset_tokens_table ................................................................................... 57ms DONE
     * 2019_08_19_000000_create_failed_jobs_table ............................................................................................ 125ms DONE
     * 2019_12_14_000001_create_personal_access_tokens_table ................................................................................. 159ms DONE
     * 2024_06_14_040520_create_table_counter ................................................................................................. 81ms DONE
     * 2024_06_14_040528_create_table_category ................................................................................................ 61ms DONE
     * 2024_06_14_040539_create_table_product ................................................................................................ 213ms DONE
     *
     * note: ingin perubahan tambah column di table counters.. kita perlu buat lagi file migration
     * php artisan migrate
     * INFO  Running migrations.
     * 2024_06_14_043008_add_column_description_to_counter .................................................................................... 54ms DONE
 *
     */
}
