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
                "permission_title" => "User Create",
                "permission_slug" => Str::slug("User Create"),
            ],
            [
                "permission_title" => "User Read",
                "permission_slug" => Str::slug("User Read"),
            ],
            [
                "permission_title" => "User Update",
                "permission_slug" => Str::slug("User Update"),
            ],
            [
                "permission_title" => "User Delete",
                "permission_slug" => Str::slug("User Delete"),
            ],
            [
                "permission_title" => "Role Craete",
                "permission_slug" => Str::slug("Role Create"),
            ],
            [
                "permission_title" => "Role Read",
                "permission_slug" => Str::slug("Role Read"),
            ],
            [
                "permission_title" => "Role Update",
                "permission_slug" => Str::slug("Role Update"),
            ],
            [
                "permission_title" => "Role Delete",
                "permission_slug" => Str::slug("Role Delete"),
            ],
            [
                "permission_title" => "Permission Create",
                "permission_slug" => Str::slug("Permission Create"),
            ],
            [
                "permission_title" => "Permission Read",
                "permission_slug" => Str::slug("Permission Read"),
            ],
            [
                "permission_title" => "Permission Update",
                "permission_slug" => Str::slug("Permission Update"),
            ],
            [
                "permission_title" => "Permission Delete",
                "permission_slug" => Str::slug("Permission Delete"),
            ],
            [
                "permission_title" => "Permission Role Create",
                "permission_slug" => Str::slug("Permission Role Create"),
            ],
            [
                "permission_title" => "Permission Role Read",
                "permission_slug" => Str::slug("Permission Role Read"),
            ],
            [
                "permission_title" => "Permission Role Update",
                "permission_slug" => Str::slug("Permission Role Update"),
            ],
            [
                "permission_title" => "Permission Role Delete",
                "permission_slug" => Str::slug("Permission Role Delete"),
            ],
        ];

        foreach($rows as $row){
            DB::table("permissions")->insert($row);
		}
    }
}
