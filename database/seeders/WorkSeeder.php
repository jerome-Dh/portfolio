<?php

namespace Database\Seeders;

use Database\Seeders\CommonForSeeders;
use Illuminate\Database\Seeder;
use App\Models\{Work};

/**
 * Class WorkSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class WorkSeeder extends Seeder
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
            $work = $this->getWork();
            Work::create($work);
        }
    }

}
