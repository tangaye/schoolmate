<?php

use Illuminate\Database\Seeder;

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
        $guardian = factory(App\Guardian::class)->create();
    }
}
