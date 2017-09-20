<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DivisionsTableSeeder::class);
        $this->call(SemestersTableSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(TermsTableSeeder::class);
        $this->call(GradeSubjectTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(GuardianTableSeeder::class);
        $this->call(InstitutionTableSeeder::class);
        $this->call(AcademicTableSeeder::class);
    }
}

