<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
        $faker = Faker::create();

        $genders = ['Male', 'Female'];

        if(DB::table('users')->get()->count() == 0){
            $secretary_user = new User();
            $secretary_user->name = $faker->name;
            $secretary_user->gender = $genders[rand(0, count($genders) - 1)];
            $secretary_user->address = $faker->city;
            $secretary_user->phone = '0776393939';
            $secretary_user->user_name = $faker->userName;
            $secretary_user->email = $faker->unique()->safeEmail;
            $secretary_user->role_id = $role_secretary->id;
            $secretary_user->password = bcrypt('secret');
            $secretary_user->save();

            $registrar_user = new User();
            $registrar_user->name = $faker->name;
            $registrar_user->gender = $genders[rand(0, count($genders) - 1)];
            $registrar_user->phone = '0886393939';
            $registrar_user->address = $faker->city;
            $registrar_user->user_name = $faker->userName;
            $registrar_user->email = $faker->unique()->safeEmail;
            $registrar_user->role_id = $role_registrar->id;
            $registrar_user->password = bcrypt('secret');
            $registrar_user->save();

        } else { echo "\e[31users table is not empty, therefore not seeding "; }

       

    }
}
