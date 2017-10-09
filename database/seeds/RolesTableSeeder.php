<?php

use Illuminate\Database\Seeder;
use App\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('roles')->get()->count() == 0){
            $secretary = Role::create([
                'name' => 'Secretary', 
                'description' => 'Responsible to update both student and guardians records. Can also delete both student and guardians records',
                'permissions' => [
                    "update-student" => "true",
                    "view-student" => "true",
                    "update-guardian" => "true",
                    "view-guardian" => "true",
                ]
            ]);

            $registrar = Role::create([
                'name' => 'Registrar', 
                'description' => 'Responsible to enter old and new student records. Can also create guardians and assigned guardians to students',
                'permissions' => [
                    'create-student' => "true",
                    'create-guardian' => "true",
                    "view-guardian" => "true",
                ]
            ]);

        } else { echo "\e[31roles table is not empty, therefore not seeding "; }

        
    }
}
