<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    private array $codes = [];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $date = date('d-m-Y');

        DB::table('awards')->insert([
            array(
                'id' => 1,
                'award' => 'REFRIGERADOR ALGO',
                'availability' => 5,
            ),
            array(
                'id' => 2,
                'award' => 'COCINA ALGO',
                'availability' => 5,
            )
            ,array(
                'id' => 3,
                'award' => 'SILLON ALGO',
                'availability' => 5,
            ),
            array(
                'id' => 4,
                'award' => 'CAMA ALGO',
                'availability' => 5,
            ),
        ]);



        for ($i = 0; $i < 20; $i++){
            $length = random_bytes(5);
            $code = bin2hex($length);

            $this->codes[] = [
                'code' => $code,
            ];
        }

        foreach ($this->codes as $code){
            DB::table('codes')->insert($code);
        }
    }
}
