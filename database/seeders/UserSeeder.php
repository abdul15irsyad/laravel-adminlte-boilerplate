<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                "user_name" => "Irsyad Abdul",
                "user_username" => "irsyadabdul",
                "user_email" => "abdulirsyad15@gmail.com",
                "user_password" => "Qwerty123",
                "role_id" => 1,
            ],
            [
                "user_name" => "John Doe",
                "user_username" => "johndoe",
                "user_email" => "johndoe@email.com",
                "user_password" => "Qwerty123",
                "role_id" => 2,
            ],
            [
                "user_name" => "Shaun",
                "user_username" => "shaun",
                "user_email" => "shaun@email.com",
                "user_password" => "Qwerty123",
                "role_id" => 3,
            ],
        ];

        foreach($rows as $row){
            $row['user_password'] = Hash::make($row['user_password']);
			DB::table("users")->insert($row);
		}
    }
}
