<?php

use Illuminate\Database\Seeder;

class AcademicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // check if institution table is empty
        $now = \Carbon\Carbon::now();

        if(DB::table('academics')->get()->count() == 0){

            DB::table('academics')->insert([

                [
                	'date_start' => '2017-08-08',
                	'date_end' => '2018-08-08',
                	'status' => 1,
                	'created_at' => $now, 
                	'updated_at' => $now
                ]

            ]);

        } else { echo "\e[31mstatus table is not empty, therefore not seeding "; }
    }
}
