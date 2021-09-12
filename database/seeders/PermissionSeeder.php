<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class PermissionSeeder extends Seeder
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
                "permission_title" => "Create User",
                "permission_slug" => Str::slug("Create User"),
            ],
            [
                "permission_title" => "Read User",
                "permission_slug" => Str::slug("Read User"),
            ],
            [
                "permission_title" => "Update User",
                "permission_slug" => Str::slug("Update User"),
            ],
            [
                "permission_title" => "Delete User",
                "permission_slug" => Str::slug("Delete User"),
            ],
            [
                "permission_title" => "Create Role",
                "permission_slug" => Str::slug("Create Role"),
            ],
            [
                "permission_title" => "Read Role",
                "permission_slug" => Str::slug("Read Role"),
            ],
            [
                "permission_title" => "Update Role",
                "permission_slug" => Str::slug("Update Role"),
            ],
            [
                "permission_title" => "Delete Role",
                "permission_slug" => Str::slug("Delete Role"),
            ],
        ];

        foreach($rows as $row){
            DB::table("permissions")->insert($row);
		}
    }
}
