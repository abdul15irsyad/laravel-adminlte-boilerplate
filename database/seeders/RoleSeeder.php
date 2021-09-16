<?php

namespace Database\Seeders;

use DB, Str;
use Illuminate\Database\Seeder;
use App\Models\Role;

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
                "role_desc" => "Has the highest access level for the entire function in account",
            ],[
                "role_name" => "Admin",
                "role_desc" => "Has the second highest access level, but can not access the Account Management and User Activity Log",
            ],[
                "role_name" => "Copywriter",
                "role_desc" => null,
            ]
        ];

        foreach($rows as $row){
			$role = new Role;
            $role->role_name = $row['role_name'];
            $role->role_slug = Str::slug($row['role_name']);
            $role->role_desc = $row['role_desc'];
            $role->save();
		}
    }
}
