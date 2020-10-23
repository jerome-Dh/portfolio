<?php

namespace Database\Seeders;

use Database\Seeders\CommonForSeeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


/**
 * Class Experience_technologieSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class Experience_technologieSeeder extends Seeder
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
            $experience_technologie = $this->getExperience_technologie();
            DB::table('experience_technologie')->insert($experience_technologie);
        }
    }

}
