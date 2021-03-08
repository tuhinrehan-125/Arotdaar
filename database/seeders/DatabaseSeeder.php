<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'imtiaz',
            "phone_no" => "01683207978",
            "address" => "Comilla",
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin1234'),
        ]);
    }
}
