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
                    'year_start' => 2014,
                    'year_end' => 2015,
                    'status' => 0,
                    'created_at' => $now, 
                    'updated_at' => $now
                ],

                [
                    'year_start' => 2015,
                    'year_end' => 2016,
                    'status' => 0,
                    'created_at' => $now, 
                    'updated_at' => $now
                ],

                [
                    'year_start' => 2016,
                    'year_end' => 2017,
                    'status' => 0,
                    'created_at' => $now, 
                    'updated_at' => $now
                ],

                [
                	'year_start' => 2017,
                	'year_end' => 2018,
                	'status' => 1,
                	'created_at' => $now, 
                	'updated_at' => $now
                ]

            ]);

        } else { echo "\e[31mstatus table is not empty, therefore not seeding "; }
    }
}
