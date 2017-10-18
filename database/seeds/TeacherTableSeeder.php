<?php

use Illuminate\Database\Seeder;
use App\Teacher;
use Carbon\Carbon;


class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if(DB::table('teachers')->get()->count() == 0){
            $teacher = new Teacher();
            $teacher->first_name = 'Pepper';
            $teacher->surname = 'Cala';
            $teacher->date_of_birth = Carbon::parse('11/06/1990')->format('d/m/Y');
            $teacher->gender = 'Female';
            $teacher->address = '20th Street, Sinkor';
            $teacher->phone = '0770700700';
            $teacher->qualification = 'High School Diploma';
            $teacher->user_name = 'perpercala';
            $teacher->email = 'teacher@example.com';
            $teacher->password = bcrypt('teacher');
            $teacher->save();

        } else { echo "\e[31teachers table is not empty, therefore not seeding "; }
    }
}
