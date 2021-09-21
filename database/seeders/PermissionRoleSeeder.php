<?php

namespace Database\Seeders;

use App\Models\PermissionRole;
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
        $rows = [
            [
                "role_id" => 1,
                "permission_ids" => [1,2,3,4,5,6,7,8,9,10],
            ],
            [
                "role_id" => 2,
                "permission_ids" => [1,2,3],
            ],
            [
                "role_id" => 3,
                "permission_ids" => [9,10],
            ],
        ];

        foreach($rows as $row){
            foreach($row['permission_ids'] as $id){
                $permission_role = new PermissionRole;
                $permission_role->role_id = $row["role_id"];
                $permission_role->permission_id = $id;
                $permission_role->save();
            }
		}
    }
}
