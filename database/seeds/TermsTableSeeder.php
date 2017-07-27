<?php

use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $semester_one = DB::table('semesters')
            ->select('id')
            ->where('name', '1st Semester')
            ->first()
            ->id;
		$semester_two = DB::table('semesters')
            ->select('id')
            ->where('name', '2nd Semester')
            ->first()
            ->id;
        $finals = DB::table('semesters')
            ->select('id')
            ->where('name', 'Finals')
            ->first()
            ->id;    

        $now = \Carbon\Carbon::now();     

        if(DB::table('terms')->get()->count() == 0){

            DB::table('terms')->insert([

                [
                	'name' => '1st Period',
                	'semester_id' => $semester_one, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
                [
                	'name' => '2nd Period',
                	'semester_id' => $semester_one, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '3rd Period',
                	'semester_id' => $semester_one, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '1st Semester Exam',
                	'semester_id' => $semester_one, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '4th Period',
                	'semester_id' => $semester_two, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '5th Period',
                	'semester_id' => $semester_two, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '6th Period',
                	'semester_id' => $semester_two, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => '2nd Semester Exam',
                	'semester_id' => $semester_two, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
                	'name' => 'Final Exam',
                	'semester_id' => $finals, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ]

            ]);

        } else { echo "\e[31mterms table is not empty, therefore not seeding "; }
    }
}
