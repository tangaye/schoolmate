<?php

use Illuminate\Database\Seeder;

class InstitutionTableSeeder extends Seeder
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

        if(DB::table('institutions')->get()->count() == 0){

            DB::table('institutions')->insert([

                [
                	'name' => 'Gbezongar Community High School', 
                	'address' => 'Bassa HighWay',
                	'motto' => 'Breeding Future Leaders',
                	'email' => 'gbezongarhigh@gmail.com',
                	'phone' => '0775633225',
                	'date_established' => '1979-01-08',
                	'created_at' => $now, 
                	'updated_at' => $now
                ]

            ]);

        } else { echo "\e[31minstitution table is not empty, therefore not seeding "; }
    }
}
