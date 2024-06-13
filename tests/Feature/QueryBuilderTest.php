<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class QueryBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete("delete from products");
        DB::delete("delete from categories");
    }

    /**
     * Query Builder
     * ● Selain menggunakan Raw Sql, Laravel Database juga memiliki fitur bernama Query Builder
     * ● Fitur ini sangat mempermudah kita ketika ingin membuat perintah ke database dibandingkan
     *   melakukannya secara manual menggunakan Raw SQL
     * ● Query Builder direpresentasikan dengan class Builder
     * ● https://laravel.com/api/10.x/Illuminate/Database/Query/Builder.html
     * ● Untuk membuat Query Builder, kita bisa gunakan function DB::table(nama)
     *
     * Query Builder Insert
     * ● Untuk melakukan Insert menggunakan Query Builder, kita bisa menggunakan method dengan
     *   prefix insert dengan parameter associative array dimana key nya adalah kolom, dan value nya
     *   adalah nilai yang akan disimpan di database
     * ● insert() untuk memasukkan data ke database, throw exception jika terjadi error misal duplicate
     *   primary key
     * ● insertGetId() untuk memasukkan data ke database, dan mengembalikan primary key yang diset
     *   secara auto generate, cocok untuk tabel dengan id auto increment
     * ● insertOrIgnore() untuk memasukkan data ke database, dan jika terjadi error, maka akan di ignore
     */

    public function testQueryBuilderInsert(){

        // DB::table("nama_table")->insert(["key" => value]) // key adalah nama column dan value ada isi data record
        // sql: select count(id) as total from categories
        DB::table("categories")->insert([
            "id" => "SANDAL",
            "name" => "Consina",
            "description" => "Sandal Gunung",
        ]);
        DB::table("categories")->insert([
            "id" => "JAKET",
            "name" => "Consina",
            "description" => "Jaket Gunung",
        ]);

        $result = DB::select("select count(id) as total from categories");

        self::assertEquals(2, $result[0]->total);

        var_dump($result);

    }

    /**
     * Query Builder Select
     * ● Ada beberapa function di Query Builder yang bisa kita gunakan untuk melakukan perintah select
     * ● select(columns), untuk mengubah select kolom, dimana defaultnya adalah semua kolom
     * ● Setelah itu, untuk mengeksekusi SQL dan menyimpannya di Collection secara langsung, kita bisa
     *   menggunakan beberapa method
     * ● get(columns), untuk mengambil seluruh data, defaultnya semua kolom diambil
     * ● first(columns), untuk mengambil data pertama, defaultnya semua kolom diambil
     * ● pluck(column), untuk mengambil salah satu kolom saja
     * ● Hasil dari Query Builder Select adalah Laravel Collection
     */

    public function testQueryBuilderSelect(){

        $this->testQueryBuilderInsert(); //insert data

        // DB::table("nama_table")->select([column_table])->get();
        // sql: select `id`, `name` from `categories`
        // untuk eksekusi query ada beberapa method get() ambil semua, first() ambil data pertama,   pluck() ambil beberpa data
        $collection = DB::table("categories")
            ->select(["id", "name"])
            ->get();

        self::assertNotNull($collection);

        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

    }

    public function testInsertDataCategories(){

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

    /**
     * Query Builder Where
     * ● Sebelum kita lanjut ke materi Update dan Delete, kita harus tahu tentang Where di Query Builder
     * ● Untuk menambahkan Where di Query Builder, kita bisa menggunakan banyak sekali method
     *   dengan awalan where…()
     *
     * Where Method                                 Keterangan
     * where(column, operator, value)               AND column operator value
     * where([condition1, condition2])              AND (condition 1 AND condition 2 AND …)
     * where(callback(Builder))                     AND (condition)
     * orWhere(column, operator, value)             OR (condition)
     * orWhere(callback(Builder))                   OR (condition …)
     * whereNot(callback(Builder))                  NOT (condition …)
     */

    public function testWhere(){

        $this->testInsertDataCategories();

        // DB::table("nama_table")->where(callback(Builder))->get(); // select where bisa di dalam callback
        // sql: select * from `categories` where (`id` = ? or `id` = ?)
        $collection = DB::table("categories")->where(function(Builder $builder){
            $builder->where('id', '=', 'SANDAL');
            $builder->orWhere('id', '=', 'JAKET');
            // select * from categories where(id = SANDAL OR id = JAKET) // sql db
        })->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     *  Where Between Method
     *  Where Method                                 Keterangan
     *  whereBetween(column, [value1, value2])       WHERE column BETWEEN value1 AND value2
     *  whereNotBetween(column, [value1,value2])     WHERE column NOT BETWEEN value1 AND value2
     */

    public function testWhereBetween(){

        $this->testInsertDataCategories();

        // DB::table("nama_table")->whereBetween(column, [record_column, record_column])->get(); // mengambil data dalam jangka waktu
        // sql: select * from `categories` where `created_at` between ? and ?
        $collection = DB::table("categories")
            ->whereBetween("created_at", ["2024-05-13 10:10:10", "2024-07-13 10:10:10"])
            ->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     *   Where In Method
     *   Where Method                                 Keterangan
     *   whereIn(column, [array])                     WHERE column IN (array)
     *   whereNotIn(column, [array])                  WHERE column NOT IN (array)
     */
    public function testWhereIn(){

        $this->testInsertDataCategories();

        // DB::table("nama_table")->whereIn(column_table, ["record_column"])->get(); // select where id tertentu
        // sql: select * from `categories` where `id` in (?, ?)
        $collection = DB::table("categories")->
        whereIn("id", ["CELANA", "JAKET"])
            ->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     *    Where Null Method
     *    Where Method                                 Keterangan
     *    whereNull(column)                            WHERE column IS NULL
     *    whereNotNull(column)                         WHERE column IS NOT NULL
     */
    public function testWhereNull(){

        $this->testInsertDataCategories();

        // DB::table("nama_table")->whereNull(column)->get(); // mengambil data yang column record nya null
        // sql: select * from `categories` where `description` is null
        $collection = DB::table("categories")
            ->whereNull("description")
            ->get();

        self::assertCount(0, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     *     Where Date Method
     *     Where Method                                 Keterangan
     *     whereDate(column, value)                     WHERE DATE(column) = value
     *     whereMonth(column, value)                    WHERE MONTH(column) = value
     *     whereDay(column, value)                      WHERE DAY(column) = value
     *     whereYear(column, value)                     WHERE YEAR(column) = value
     *     whereTime(column, value)                     WHERE TIME(column) = value
     */
    public function testWhereDate(){

        $this->testInsertDataCategories();

        // DB::table("nama_table")->whereNull(column)->get(); // mengambil data berdasarkan colum date
        // sql: select * from `categories` where date(`created_at`) = ?
        $collection = DB::table("categories")
            ->whereDate("created_at", "2024-06-13")
            ->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     * Query Builder Update
     * ● Setelah kita tahu cara menggunakan Where, sekarang kita bahas tentang Update Method
     * ● Untuk melakukan Update, kita bisa menggunakan method update(array)
     * ● Dimana parameter nya kita bisa mengirim associative array yang berisi kolom -> value
     */

    public function testUpdate(){

        $this->testInsertDataCategories();

        // DB::table("name_table")->where("column", "operator", "record_column")->update(["column" => "record_column"])
        // sql: update `categories` set `name` = ? where `id` = ?
        DB::table("categories")
            ->where("id", "=", "CELANA")
            ->update(["name" => "BOXER"]);

        // sql: select * from `categories` where `name` = ?
        $collection = DB::table("categories")->where("name", "=", "BOXER")->get();

        self::assertCount(1, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     * Upsert (Update or Insert)
     * ● Query Builder menyediakan method untuk melakukan update or insert, dimana ketika mencoba
     *   melakukan update, jika datanya tidak ada, maka akan dilakukan insert data baru
     * ● Kita bisa menggunakan method updateOrInsert(attributes, values)
     */

    public function testUpsert(){

        // DB::table("name_table")->updateOrInsert(attributes[array_assosiative(select)], values[array_assosiative(yang mau di update)]);
        // sql: insert into `categories` (`id`, `name`, `description`, `created_at`) values (?, ?, ?, ?)
        DB::table("categories")
            ->updateOrInsert(
                [
                    "id" => "CELANA"
                ],
                [
                    "name" => "Jeans",
                    "description" => "Celana Pria",
                    "created_at" => "2024-05-13 10:10:10"
                ]);

        // sql: select * from `categories` where `id` = ?
        $collection = DB::table("categories")
            ->where("id", "=", "CELANA")
            ->get();

        self::assertCount(1, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     * Increment dan Decrement
     * ● Query Builder juga menyediakan cara mudah untuk melakukan increment atau decrement
     * ● Jadi kita tidak perlu melakukan increment atau decrement secara manual di kode PHP
     * ● Kita bisa menggunakan method
     * ● increment(column, increment) untuk melakukan increment
     * ● decrement(column, decrement) untuk melakukan decrement
     */

    public function testQueryBuilderIncrement(){

        // sql: update `counters` set `counter` = `counter` + 1 where `id` = ?
        DB::table("counters")
            ->where("id", "=", "sample")
            ->increment("counter", 1);

        // sql: select * from `counters` where `id` = ?
        $collection = DB::table("counters")
            ->where("id", "=" ,"sample")
            ->get();

        self::assertCount(1, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     * Query Builder Delete
     * ● Untuk melakukan delete, kita bisa menggunakan method
     * ● delete() untuk melakukan Sql DELETE, dan
     * ● truncate() untuk melakukan TRUNCATE table
     */

    public function testQueryBuilderDelete(){

        $this->testInsertDataCategories();

        // sql: delete from `categories` where `id` = ?
        DB::table("categories")
            ->where("id", "=", "CELANA")
            ->delete();

        // sql: select * from `categories` where `id` = ?
        $collection = DB::table("categories")
            ->where("id", "=", "CELANA")
            ->get();

        self::assertCount(0, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

    }

    /**
     * Query Builder Join
     * ● Query Builder juga menyediakan cara mudah untuk melakukan join, dengan menggunakan
     *   beberapa method
     * ● join(table, column, operator, ref_column) untuk JOIN atau INNER JOIN
     * ● leftJoin(table, column, operator, ref_column) untuk LEFT JOIN
     * ● rightJoin(table, column, operator, ref_column) untuk RIGHT JOIN
     * ● crossJoin(table, column, operator, ref_column) untuk CROSS JOIN
     */

    public function insertTableProduct(){

        $this->testInsertDataCategories();

        DB::table("products")->insert([
            "id" => "1",
            "name" => "Celana Eiger",
            "description" => "Celana Gunung Eiger",
            "price" => 100000,
            "category_id" => "CELANA",
        ]);

        DB::table("products")->insert([
            "id" => "2",
            "name" => "Celana Consina",
            "description" => "Celana Gunung Consina",
            "price" => 90000,
            "category_id" => "CELANA",
        ]);

    }

    public function testQueryBuilderJoin(){

        $this->insertTableProduct();

        // sql: select `products`.`id`, `products`.`name`, `categories`.`name` as `category_name`, `products`.`price` from `products` inner join `categories` on `products`.`category_id` = `categories`.`id`
        $collection = DB::table("products")
            ->join("categories", "products.category_id", "=", "categories.id")
            ->select("products.id", "products.name", "categories.name as category_name", "products.price") // select() // data apa saja yang mau di tampilkan // jika menggunakan alias, maka aliasnya yang di tampilkan
            ->get();

        self::assertCount(2, $collection);
        for ($i = 0; $i < $this->count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }

        var_dump($collection);
        // result: {"id":"1","name":"Celana Eiger","category_name":"Celana","price":100000}

    }

    public function testQueryBuilderLeftJoin(){

        $this->insertTableProduct();

        // sql: select `products`.`id`, `products`.`name`, `categories`.`name` as `category_name`, `products`.`price` from `products` left join `categories` on `products`.`category_id` = `categories`.`id`
        $collection = DB::table("products")
            ->leftJoin("categories", "products.category_id", "=", "categories.id")
            ->select("products.id", "products.name", "categories.name as category_name", "products.price") // select() // data apa saja yang mau di tampilkan // jika menggunakan alias, maka aliasnya yang di tampilkan
            ->get();

        self::assertCount(2, $collection);
        for ($i = 0; $i < $this->count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }

        var_dump($collection);
        // result: {"id":"1","name":"Celana Eiger","category_name":"Celana","price":100000}

    }

    /**
     * Query Builder Ordering
     * ● Query Builder juga memiliki method untuk memudahkan kita melakukan pengurutan data
     *   menggunakan
     * ● orderBy(column, order) dimana order bisa asc atau desc
     */

    public function testQueryBuilderOrdering(){

        $this->insertTableProduct();

        // sql: select * from `products` where `id` is not null order by `price` desc, `name` asc
        $collection = DB::table("products")
            ->whereNotNull("id")
            ->orderBy("price", "desc")
            ->orderBy("name", "asc")
            ->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item){
            Log::info(json_encode($item));
        });

        var_dump($collection);

        /**
         * result:
         * {"id":"1","name":"Celana Eiger","description":"Celana Gunung Eiger","price":100000,"category_id":"CELANA","created_at":"2024-06-13 17:22:39"}
         * {"id":"2","name":"Celana Consina","description":"Celana Gunung Consina","price":90000,"category_id":"CELANA","created_at":"2024-06-13 17:22:39"}
         */

    }


}
