<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
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
                "module_name" => "User",
            ],[
                "module_name" => "Role",
            ],[
                "module_name" => "Module",
            ]
        ];

        foreach($rows as $row){
            $row['module_slug'] = Str::slug($row['module_name']);
			DB::table("modules")->insert($row);
		}
    }
}
