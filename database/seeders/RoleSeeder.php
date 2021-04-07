<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Str;

class RoleSeeder extends Seeder
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
                "role_name" => "Super Admin",
            ],[
                "role_name" => "Admin",
            ],[
                "role_name" => "Copywriter",
            ]
        ];

        foreach($rows as $row){
            $row['role_slug'] = Str::slug($row['role_name']);
			DB::table("roles")->insert($row);
		}
    }
}
