<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function Laravel\Prompts\select;

class CrudSQLTest extends TestCase
{
    /**
     * CRUD SQL
     * ● Dengan menggunakan DB Facade, kita bisa melakukan Raw Query (query ke database secara manual)
     * ● Walaupun pada kenyataannya saat kita menggunakan Laravel, kita akan banyak menggunakan
     *   Eloquent ORM, tapi pada kasus tertentu ketika kita butuh performa yang sangat cepat, ada
     *   baiknya kita lakukan menggunakan Raw Query
     *
     * Function Raw SQL
     * Function                                 Keterangan
     * DB::insert(sql, array): bool             Untuk melakukan insert data
     * DB::update(sql, array): int              Untuk melakukan update data
     * DB::delete(sql, array): int              Untuk melakukan update data
     * DB::select(sql, array): array            Untuk melakukan select data
     * DB::statement(sql, array): bool          Untuk melakukan jenis sql lain
     * DB::unprepared(sql): bool                Untuk melakukan sql bukan prepared statement
     */

    protected function setUp(): void
    {

        // setipa unit test di jalankan ulang data akan di hapus
        // supaya tidak redudansi

        parent::setUp();
        DB::delete("DELETE FROM categories");

    }

    public function testCrud(): void
    {
        // insert
        DB::insert("INSERT INTO categories(id, name, description, created_at) values(?, ?, ?, ?)", [
            "GADGET", "Gadget", "Gadget Category", "2024-06-04 00:00:00"
        ]); // DB::insert(string_query, [binding_data_preparestatement]) // ? preparedsttement yang akan di inject ke array

        // get detail
        $result = DB::select("SELECT * FROM categories WHERE id = ?", [
            "GADGET"
        ]); // DB::select(string_query, [binding_data_preparestatement]); // ? preparedsttement yang akan di inject ke array

        $this->assertEquals(1, $this->count($result));
        $this->assertEquals("GADGET", $result[0]->id);
        $this->assertEquals("Gadget", $result[0]->name);
        $this->assertEquals("Gadget Category", $result[0]->description);
        $this->assertEquals("2024-06-04 00:00:00", $result[0]->created_at);

        var_dump($result);

        /**
         * result:
         * array(1) {
         * [0]=> object(stdClass)#957 (4) {
         * ["id"]=> string(6) "GADGET"
         * ["name"]=> string(6) "Gadget"
         * ["description"]=> string(15) "Gadget Category"
         * ["created_at"]=> string(19) "2024-06-04 00:00:00"
         *   }
         * }
         */

    }

    /**
     * Named Binding
     * ● Kadang menggunakan parameter ? (tanda tanya) membingungkan saat kita membuat query dengan
     *   parameter yang banyak
     * ● Laravel mendukung fitur bernama named binding, sehingga kita bisa mengganti ? (tanda tanya)
     *   menjadi nama parameter , dan data bisa kita kirim menggunakan array dengan key sesuai nama
     *   parameter nya
     */

    public function testNamedBinding(): void{

        // insert
        DB::insert("INSERT INTO categories(id, name, description, created_at) VALUES(:id, :name, :description, :created_at)", [
           "id" => "GADGET",
           "name" => "Gadget",
           "description" => "Gadget Category",
           "created_at" => "2024-06-04 00:00:00",
        ]); // DB::select(string_query, [binding_named_binding]); // :named_binding yang akan di inject ke array

        // get detail
        $result = DB::select("SELECT * FROM categories WHERE id = ?", [
            "GADGET"
        ]); // DB::select(string_query, [binding_data_preparestatement]);

        $this->assertEquals(1, $this->count($result));
        $this->assertEquals("GADGET", $result[0]->id);
        $this->assertEquals("Gadget", $result[0]->name);
        $this->assertEquals("Gadget Category", $result[0]->description);
        $this->assertEquals("2024-06-04 00:00:00", $result[0]->created_at);

        var_dump($result);

        /**
         * result:
         * array(1) {
         * [0]=> object(stdClass)#957 (4) {
         * ["id"]=> string(6) "GADGET"
         * ["name"]=> string(6) "Gadget"
         * ["description"]=> string(15) "Gadget Category"
         * ["created_at"]=> string(19) "2024-06-04 00:00:00"
         *   }
         * }
         */

    }

}
