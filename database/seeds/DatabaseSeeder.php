<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ComCodeTableSeeder::class);
        $this->call(TblCompanyTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TblJenisRegisterTableSeeder::class);
        $this->call(TblRegisterTableSeeder::class);
    }
}
