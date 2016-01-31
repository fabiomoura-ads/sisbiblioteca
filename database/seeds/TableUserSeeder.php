<?php

use Illuminate\Database\Seeder;

class TableUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
			"name" => "fabio",
			"email" => "fabiomoura.ads@gmail.com",
			"password" => "123"
		]);
    }
}
