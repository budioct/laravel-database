<?php

namespace Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    /**
     * Database Transaction
     * ● Laravel Database juga memiliki fitur untuk melakukan database transaction secara otomatis
     * ● Dengan begitu, kita tidak perlu melakukan start transaction dan commit/rollback secara manual lagi
     * ● Kita bisa menggunakan function DB::transactions(function)
     * ● Di dalam function tersebut kita bisa melakukan perintah database, jika terjadi error, secara
     *   otomatis transaksi akan di rollback
     */

    protected function setUp(): void
    {

        // setipa unit test di jalankan ulang data akan di hapus
        // supaya tidak redudansi

        parent::setUp();
        DB::delete("DELETE FROM categories");

    }

    public function testTransactionSucces()
    {
        // transaction
        DB::transaction(function () {
            // insert
            DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                "GADGET", "Gadget", "Gadget Category", "2024-06-04 00:00:00"
            ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array

            // insert
            DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                "FOOD", "food", "Food Category", "2024-06-04 00:00:00"
            ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array
        });
        // get detail
        $results = DB::select("SELECT * FROM categories");

        self::assertCount(2, $results);

    }

    public function testTransactionFailed()
    {
        try {
            // transaction
            DB::transaction(function () {
                // insert
                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "GADGET", "Gadget", "Gadget Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array

                // insert
                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "GADGET", "food", "Food Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array
            });
        } catch (QueryException $error) {
            // expected
        }

        // get detail
        $results = DB::select("SELECT * FROM categories");

        self::assertCount(0, $results);

    }

    /**
     * Manual Database Transaction
     * ● Selain menggunakan fitur otomatis, kita juga bisa melakukan database transaction secara manual
     *   menggunakan Laravel Database
     * ● Kita bisa gunakan beberapa function
     * ● DB::beginTransaction() untuk memulai transaksi
     * ● DB::commit() untuk melakukan commit transaksi
     * ● DB::rollBack() untuk melakukan rollback transaksi
     */

    public function testTransactionManualSucces()
    {
        // transaction
        try {
            DB::beginTransaction(); // begin()
            DB::transaction(function () {

                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "GADGET", "Gadget", "Gadget Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array


                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "FOOD", "food", "Food Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array
            });
            DB::commit(); // comit()
        } catch (QueryException $error) {
            // expeted
            DB::rollBack(); // rollback()
        }
        // get detail
        $results = DB::select("SELECT * FROM categories");

        self::assertCount(2, $results);

    }

    public function testTransactionManualFailed()
    {
        // transaction
        try {
            DB::beginTransaction(); // begin()
            DB::transaction(function () {

                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "GADGET", "Gadget", "Gadget Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array


                DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
                    "GADGET", "food", "Food Category", "2024-06-04 00:00:00"
                ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array
            });
            DB::commit(); // comit()
        } catch (QueryException $error) {
            // expeted
            DB::rollBack(); // rollback()
        }
        // get detail
        $results = DB::select("SELECT * FROM categories");

        self::assertCount(0, $results);

    }

}
