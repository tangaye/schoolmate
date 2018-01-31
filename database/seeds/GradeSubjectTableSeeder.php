<?php

use Illuminate\Database\Seeder;

class GradeSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $grade_twelve = DB::table('grades')
            ->select('id')
            ->where('name', '12th Grade')
            ->first()
            ->id;

        $grade_eleven = DB::table('grades')
            ->select('id')
            ->where('name', '11th Grade')
            ->first()
            ->id;

        $grade_ten = DB::table('grades')
            ->select('id')
            ->where('name', '10th Grade')
            ->first()
            ->id;

        $grade_nine = DB::table('grades')
            ->select('id')
            ->where('name', '9th Grade')
            ->first()
            ->id;

        $grade_eignt = DB::table('grades')
            ->select('id')
            ->where('name', '8th Grade')
            ->first()
            ->id;

        $maths = DB::table('subjects')
            ->select('id')
            ->where('name', 'Mathematics')
            ->first()
            ->id;

        $physics = DB::table('subjects')
            ->select('id')
            ->where('name', 'Physics')
            ->first()
            ->id;

        $french = DB::table('subjects')
            ->select('id')
            ->where('name', 'French')
            ->first()
            ->id;


        $biology = DB::table('subjects')
            ->select('id')
            ->where('name', 'Biology')
            ->first()
            ->id;

        $english = DB::table('subjects')
            ->select('id')
            ->where('name', 'English')
            ->first()
            ->id;

        $science = DB::table('subjects')
            ->select('id')
            ->where('name', 'Science')
            ->first()
            ->id;

        $geography = DB::table('subjects')
            ->select('id')
            ->where('name', 'Geography')
            ->first()
            ->id;

        if(DB::table('grade_subject')->get()->count() == 0){

            DB::table('grade_subject')->insert([

                [
                    'subject_id' => $maths,
                    'grade_id' => $grade_eignt
                ],

                [
                    'subject_id' => $english,
                    'grade_id' => $grade_eignt
                ],
                [
                    'subject_id' => $science,
                    'grade_id' => $grade_eignt
                ],
                [
                    'subject_id' => $geography,
                    'grade_id' => $grade_eignt
                ],
        		[
                	'subject_id' => $maths,
                	'grade_id' => $grade_nine 
                ],
                [
                    'subject_id' => $science,
                    'grade_id' => $grade_nine 
                ],
                [
                    'subject_id' => $physics,
                    'grade_id' => $grade_nine 
                ],
                [
                    'subject_id' => $french,
                    'grade_id' => $grade_nine 
                ],
                [
                    'subject_id' => $biology,
                    'grade_id' => $grade_nine
                ],
                [
                    'subject_id' => $geography,
                    'grade_id' => $grade_nine
                ],
                [
                    'subject_id' => $english,
                    'grade_id' => $grade_nine
                ],
                [
                    'subject_id' => $biology,
                    'grade_id' => $grade_ten
                ],
                [
                    'subject_id' => $french,
                    'grade_id' => $grade_ten 
                ],
                [
                    'subject_id' => $geography,
                    'grade_id' => $grade_ten
                ],
                [
                    'subject_id' => $physics,
                    'grade_id' => $grade_ten 
                ],
                [
                    'subject_id' => $maths,
                    'grade_id' => $grade_ten 
                ],
                [
                    'subject_id' => $biology,
                    'grade_id' => $grade_eleven 
                ],
                [
                    'subject_id' => $geography,
                    'grade_id' => $grade_eleven 
                ],
                [
                    'subject_id' => $physics,
                    'grade_id' => $grade_eleven 
                ],
        		[
                	'subject_id' => $maths,
                	'grade_id' => $grade_twelve
                ],
                [
                	'subject_id' => $french,
                	'grade_id' => $grade_twelve 
                ],
                [
                    'subject_id' => $biology,
                    'grade_id' => $grade_twelve
                ]

            ]);

        } else { echo "\e[31mgrade-subject table is not empty, therefore not seeding "; }


    }
}
