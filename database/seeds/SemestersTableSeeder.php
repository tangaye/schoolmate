<?php

use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = \Carbon\Carbon::now();
        // check if division table is empty
        if(DB::table('semesters')->get()->count() == 0){

            DB::table('semesters')->insert([

                ['name' => '1st Semester', 'created_at' => $now, 'updated_at' => $now],
                ['name' => '2nd Semester', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Finals', 'created_at' => $now, 'updated_at' => $now]

            ]);

        } else { echo "\e[31msemesters table is not empty, therefore not seeding "; }
    }
}
