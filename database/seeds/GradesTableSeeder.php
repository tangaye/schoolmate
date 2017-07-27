<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $senior_high = DB::table('divisions')
            ->select('id')
            ->where('name', 'Senior High')
            ->first()
            ->id;
		$junior_high = DB::table('divisions')
            ->select('id')
            ->where('name', 'Junior High')
            ->first()
            ->id;
		$elementary  = DB::table('divisions')
            ->select('id')
            ->where('name', 'Elementary')
            ->first()
            ->id;

        $kindergarden  = DB::table('divisions')
            ->select('id')
            ->where('name', 'Kindergarden')
            ->first()
            ->id; 

        $nursery  = DB::table('divisions')
            ->select('id')
            ->where('name', 'Nursery')
            ->first()
            ->id;   

        $now = \Carbon\Carbon::now();     

        if(DB::table('grades')->get()->count() == 0){

            DB::table('grades')->insert([

                [
                	'name' => '12th Grade',
                	'division_id' => $senior_high, 
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
                [
                	'name' => '11th Grade', 
                	'division_id' => $senior_high,
                	'created_at' => $now, 
                	'updated_at' => $now
                ],
        		[
        			'name' => '10th Grade',
        			'division_id' => $senior_high, 
        			'created_at' =>  $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '9th Grade',
        			'division_id' => $junior_high, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '8th Grade',
        			'division_id' => $junior_high, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '7th Grade',
        			'division_id' => $junior_high, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '6th Grade',
        			'division_id' => $elementary, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '5th Grade',
        			'division_id' => $elementary, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '4th Grade',
        			'division_id' => $elementary, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '3rd Grade',
        			'division_id' => $kindergarden, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '2nd Grade',
        			'division_id' => $kindergarden, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => '1st Grade',
        			'division_id' => $kindergarden, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => 'Kindergarden 2',
        			'division_id' => $kindergarden, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => 'Kindergarden 1',
        			'division_id' => $kindergarden, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		],
        		[
        			'name' => 'Preparatory',
        			'division_id' => $nursery, 
        			'created_at' => $now, 
        			'updated_at' => $now
        		]

            ]);

        } else { echo "\e[31mgrades table is not empty, therefore not seeding "; }
    }
}
