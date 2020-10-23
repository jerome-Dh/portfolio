<?php

namespace Database\Seeders;

use Database\Seeders\CommonForSeeders;
use Illuminate\Database\Seeder;
use App\Models\{Skill};

/**
 * Class SkillSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class SkillSeeder extends Seeder
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
        $names = [
            'PHP',
            'Java',
            'JavaScript',
            'others',
        ];
        $subnames = [
            'PHP 7.4',
            'JDK 12',
            'JS V8',
            'others',
        ];

        for($i = 0; $i < count($names); $i++) {

            Skill::create([
                'name_en' => $names[$i],
                'name_fr' => $names[$i],
                'subname_en' => $subnames[$i],
                'subname_fr' => $subnames[$i],
            ]);
        }
    }

}
