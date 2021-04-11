<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_roles = [
            [
                "role_id" => 1,
                "permission_ids" => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
            ],
            [
                "role_id" => 2,
                "permission_ids" => [],
            ],
            [
                "role_id" => 3,
                "permission_ids" => [],
            ],
        ];

        foreach($permission_roles as $permission_role){
            foreach($permission_role['permission_ids'] as $permission_id){
                $row = [
                    "role_id" => $permission_role["role_id"],
                    "permission_id" => $permission_id,
                ];
                DB::table("permission_roles")->insert($row);
            }
		}
    }
}
