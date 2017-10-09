<?php

use Illuminate\Database\Seeder;
use App\Admin;


class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        if(DB::table('admins')->get()->count() == 0){
            $admin = new Admin();
            $admin->user_name = 'yarpakwolo';
            $admin->email = 'admin@example.com';
            $admin->password = bcrypt('admin1234');
            $admin->save();

        } else { echo "\e[31admins table is not empty, therefore not seeding "; }
    }
}
