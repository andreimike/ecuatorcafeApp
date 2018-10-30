<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FirstSerialNumberIndex extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
           'serial_number' => 0,
        ]);
    }
}
