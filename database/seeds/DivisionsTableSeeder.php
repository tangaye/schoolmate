<?php

use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        // check if division table is empty
        $now = \Carbon\Carbon::now();

        if(DB::table('divisions')->get()->count() == 0){

            DB::table('divisions')->insert([

                ['name' => 'Senior High', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Junior High', 'created_at' => $now, 'updated_at' => $now],
        		['name' => 'Elementary', 'created_at' =>  $now, 'updated_at' => $now],
        		['name' => 'Kindergarden', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Nursery', 'created_at' => $now, 'updated_at' => $now]

            ]);

        } else { echo "\e[31mdivisions table is not empty, therefore not seeding "; }

    }
}
