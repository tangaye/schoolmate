<?php

use Illuminate\Database\Seeder;
use App\Guardian;


class GuardianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        if(DB::table('guardians')->get()->count() == 0){
            $guardian = new Guardian();
            $guardian->first_name = 'John';
            $guardian->surname = 'Flomokue';
            $guardian->gender = 'Male';
            $guardian->address = '12th Street, Sinkor';
            $guardian->phone = '0770700700';
            $guardian->user_name = 'johnflomokue';
            $guardian->email = 'john@example.com';
            $guardian->relationship = 'Father';
            $guardian->password = bcrypt('guardian');
            $guardian->save();

        } else { echo "\e[31guardians table is not empty, therefore not seeding "; }
    }
}
