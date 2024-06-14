<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RollbackDatabaseMigrationTest extends TestCase
{
    /**
     * Rollback Database Migration
     * ● Saat selesai menjalankan migration, kadang kita ingin membatalkan migration tersebut
     * ● Kita bisa membatalkan migration, atau istilahnya adalah rollback
     * ● Rollback akan dijalankan dari mulai migration file terakhir yang sukses, ke migration file
     *   sebelumnya secara bertahap
     * ● Untuk menjalankan rollback, kita harus tentukan berapa jumlah file migration yang akan di rollback
     *   menggunakan perintah :
     *   php artisan migrate:rollback --step=jumlah
     * ● Dimana jumlah berisi angka jumlah file migration yang akan di follback
     *
     * note: sebelum roolback migration kita perlu check status migration terlebih dahulu supaya kita tau urutan migration nya
     *
     * ❯ php artisan migrate:status
     * // [1] Ran artinya semua migration sudah di jalankan semua
     * // setiap migration yang di roolback akan di mulai paling bawah file
     * Migration name .................................................................................................................... Batch / Status
     * 2014_10_12_000000_create_users_table ..................................................................................................... [1] Ran
     * 2014_10_12_100000_create_password_reset_tokens_table ..................................................................................... [1] Ran
     * 2019_08_19_000000_create_failed_jobs_table ............................................................................................... [1] Ran
     * 2019_12_14_000001_create_personal_access_tokens_table .................................................................................... [1] Ran
     * 2024_06_14_040520_create_table_counter ................................................................................................... [1] Ran
     * 2024_06_14_040528_create_table_category .................................................................................................. [1] Ran
     * 2024_06_14_040539_create_table_product ................................................................................................... [1] Ran
     * 2024_06_14_043008_add_column_description_to_counter ...................................................................................... [2] Ran
     *
     * // kita melakukan 2 kali roolback migration
     * ❯ php artisan migrate:rollback --step=1 // menjalankan roolback sekali
     * INFO  Rolling back migrations.
     * 2024_06_14_043008_add_column_description_to_counter ................................................................................... 121ms DONE
     *
     * ❯ php artisan migrate:rollback --step=1
     * INFO  Rolling back migrations.
     * 2024_06_14_040539_create_table_product ................................................................................................. 22ms DONE
     *
     * // check status migration lagi
     * // Pending artinya tertunda atau belum dijalankan
     * ❯ php artisan migrate:status
     * Migration name .................................................................................................................... Batch / Status
     * 2014_10_12_000000_create_users_table ..................................................................................................... [1] Ran
     * 2014_10_12_100000_create_password_reset_tokens_table ..................................................................................... [1] Ran
     * 2019_08_19_000000_create_failed_jobs_table ............................................................................................... [1] Ran
     * 2019_12_14_000001_create_personal_access_tokens_table .................................................................................... [1] Ran
     * 2024_06_14_040520_create_table_counter ................................................................................................... [1] Ran
     * 2024_06_14_040528_create_table_category .................................................................................................. [1] Ran
     * 2024_06_14_040539_create_table_product ................................................................................................... Pending
     * 2024_06_14_043008_add_column_description_to_counter ...................................................................................... Pending
     *
     * // jika tidak ada masalah kita bisa lakukan
     * ❯ php artisan migrate
     * INFO  Running migrations.
     * 2024_06_14_040539_create_table_product ................................................................................................ 153ms DONE
     * 2024_06_14_043008_add_column_description_to_counter .................................................................................... 25ms DONE
     *
     * // berhasil di migrate kembali
    */
}
