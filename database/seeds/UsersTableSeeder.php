<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$role_secretary = Role::where('name', 'Secretary')->first();
    	$role_registrar = Role::where('name', 'Registrar')->first();

        //


        $genders = ['Male', 'Female'];

        if(DB::table('users')->get()->count() == 0){
            $secretary_user = new User();
            $secretary_user->name = 'Peter Pan';
            $secretary_user->gender = $genders[rand(0, count($genders) - 1)];
            $secretary_user->address = 'A.B Tolber Road, Paynesville';
            $secretary_user->phone = '0776393939';
            $secretary_user->user_name = 'peterpan';
            $secretary_user->email = 'user@example.com';
            $secretary_user->role_id = $role_secretary->id;
            $secretary_user->password = bcrypt('user1234');
            $secretary_user->save();

            $registrar_user = new User();
            $registrar_user->name = 'James Bond';
            $registrar_user->gender = $genders[rand(0, count($genders) - 1)];
            $registrar_user->phone = '0886393939';
            $registrar_user->address = '13th, Sinkor';
            $registrar_user->user_name = 'jamesbond';
            $registrar_user->email = 'user2@example.com';
            $registrar_user->role_id = $role_registrar->id;
            $registrar_user->password = bcrypt('secret');
            $registrar_user->save();

        } else { echo "\e[31users table is not empty, therefore not seeding "; }

       

    }
}
