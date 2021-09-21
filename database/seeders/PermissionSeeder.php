<?php

namespace Database\Seeders;

use App\Models\Permission;
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
            ],
            [
                "permission_title" => "Read User",
            ],
            [
                "permission_title" => "Update User",
            ],
            [
                "permission_title" => "Delete User",
            ],
            [
                "permission_title" => "Create Role",
            ],
            [
                "permission_title" => "Read Role",
            ],
            [
                "permission_title" => "Update Role",
            ],
            [
                "permission_title" => "Delete Role",
            ],
            [
                "permission_title" => "Read Permission",
            ],
            [
                "permission_title" => "Read Activity Log",
            ],
        ];

        foreach($rows as $row){
            $permission = new Permission;
            $permission->permission_title = $row['permission_title'];
            $permission->permission_slug = Str::slug($row['permission_title']);
            $permission->save();
		}
    }
}
