<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_accesses = [
            [
                "role_id" => 1,
                "module_access_ids" => [1,2,3,4,5,6,7,8,9,10,11,12],
            ],
            [
                "role_id" => 2,
                "module_access_ids" => [5,6,7,8],
            ],
            [
                "role_id" => 3,
                "module_access_ids" => [],
            ],
        ];

        foreach($role_accesses as $role_access){
            foreach($role_access['module_access_ids'] as $module_access_id){
                $row = [
                    "role_id" => $role_access["role_id"],
                    "module_access_id" => $module_access_id,
                ];
                DB::table("role_accesses")->insert($row);
            }
		}
    }
}
