<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
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

        if(DB::table('subjects')->get()->count() == 0){

            DB::table('subjects')->insert([

                [
                	'name' => 'Mathematics',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
                [
                	'name' => 'Physics',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'French',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Geography',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Religious Education',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Social Studies',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Physical Education',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Accounting',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Biology',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Drawing',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Reading',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Literature',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'English',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Science',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Health Science',
                	'created_at' => $now, 
                	'updated_at' => $now
                ],

            ]);

        } else { echo "\e[31msubjects table is not empty, therefore not seeding "; }
    }
}
