<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Hash;

class ModuleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                "module_id" => 1,
                "module_accesses" => ["Create","Read","Update","Delete"],
            ],
            [
                "module_id" => 2,
                "module_accesses" => ["Create","Read","Update","Delete"],
            ],
            [
                "module_id" => 3,
                "module_accesses" => ["Create","Read","Update","Delete"],
            ],
        ];

        foreach($modules as $module){
            foreach($module['module_accesses'] as $module_access){
                $row = [
                    "module_id" => $module["module_id"],
                    "module_access_name" => $module_access,
                ];
                DB::table("module_accesses")->insert($row);
            }
		}
    }
}
