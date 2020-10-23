<?php

namespace Database\Seeders;

use Database\Seeders\CommonForSeeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


/**
 * Class Module_skillSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class Module_skillSeeder extends Seeder
{
    /**
     * Trait CommonForSeeders
     */
     use CommonForSeeders;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            $module_skill = $this->getModule_skill();
            DB::table('module_skill')->insert($module_skill);
        }
    }

}
