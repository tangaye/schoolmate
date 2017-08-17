<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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

        if(DB::table('users')->get()->count() == 0){

            DB::table('users')->insert([

                [
                	'first_name' => 'Nathan',
                	'surname' => 'Siafa',
                	'gender' => 'Male',
                	'date_of_birth' => $now,
                	'address' => 'Elwa Junction',
                	'education' => 'High School Diploma',
                	'country' => 'Liberia',
                	'type' => 'admin',
                	'password' => bcrypt('admin'),
                	'user_name' => 'admin',
                	'created_at' => $now, 
                	'updated_at' => $now
                ]

            ]);
        } else { echo "\e[31musers table is not empty, therefore not seeding "; }    
    }
}
