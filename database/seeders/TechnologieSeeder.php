<?php

namespace Database\Seeders;

use Database\Seeders\CommonForSeeders;
use Illuminate\Database\Seeder;
use App\Models\{Technologie};

/**
 * Class TechnologieSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class TechnologieSeeder extends Seeder
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
            $technologie = $this->getTechnologie();
            Technologie::create($technologie);
        }
    }

}
