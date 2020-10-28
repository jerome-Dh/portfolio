<?php

namespace Database\Seeders;

use App\Models\{User, Experience, Technologie, Skill, Module, Work, Illustration};
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Trait CommonForSeeders
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 00:09
 */
trait CommonForSeeders
{

    /**
     * Array of datas <<User>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getUser()
    {
         return [
             'name' => \Str::random(random_int(10, 15)),
             'email' => \Str::random(10).'@site.com',
             'password' => Hash::make('123456'),
             'role' => random_int(0, 2),
		];
    }

    /**
     * Array of datas <<Experience_technologie>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getExperience_technologie()
    {
         return [
			'experience_id' => Experience::create($this->getExperience())->id,
			'technologie_id' => Technologie::create($this->getTechnologie())->id,
		];
    }

    /**
     * Array of datas <<Experience>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getExperience()
    {
         return [
			'year' => ''.(random_int(2014, 2020)),
			'name_en' => \Str::random(random_int(10, 15)),
			'name_fr' => \Str::random(random_int(10, 15)),
			'description_en' => \Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)),
			'description_fr' => \Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)),
            'image' => 'c'.random_int(1, 5).'.png',
			'source' => 'https://www.github.com/jerome-dh/'.\Str::random(random_int(10, 15)),
		];
    }

    /**
     * Array of datas <<Technologie>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getTechnologie()
    {
         return [
			'name_en' => \Str::random(random_int(10, 15)),
			'name_fr' => \Str::random(random_int(10, 15)),
            'image' => 'c'.random_int(1, 5).'.png',
		];
    }

    /**
     * Array of datas <<Skill>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getSkill()
    {
        $names = [
            'PHP',
            'Java',
            'JavaScript',
        ];
        $subnames = [
            'PHP 7.4',
            'JDK 12',
            'JS V8',
        ];
        $index = random_int(0, count($names) - 1);
        return [
            'name_en' => $names[$index] . ' '.\Str::random(2),
            'name_fr' => $names[$index]. ' '.\Str::random(2),
            'subname_en' => $subnames[$index],
            'subname_fr' => $subnames[$index],
        ];
    }

    /**
     * Array of datas <<Module_skill>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getModule_skill()
    {
         return [
			'module_id' => Module::create($this->getModule())->id,
			'skill_id' => Skill::create([
                    'name_en' => \Str::random(15),
                    'name_fr' => \Str::random(15),
                    'subname_en' => \Str::random(15),
                    'subname_fr' => \Str::random(15),
                ])->id,
            ];
    }

    /**
     * Array of datas <<Module>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getModule()
    {
         return [
			'name_en' => \Str::random(random_int(6, 13)),
			'name_fr' => \Str::random(random_int(6, 13)),
			'leved' => random_int(1, 5),
            'image' => 'c'.random_int(1, 5).'.png',
		];
    }

    /**
     * Array of datas <<Work>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getWork()
    {
         return [
			'name_en' => \Str::random(random_int(10, 15)),
			'name_fr' => \Str::random(random_int(10, 15)),
			'title_en' => \Str::random(random_int(10, 15)),
			'title_fr' => \Str::random(random_int(10, 15)),
			'description_en' => \Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)),
			'description_fr' => \Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)).' '.\Str::random(random_int(10, 15)),
            'image' => 'c'.random_int(1, 5).'.png',
			'source' => 'https://www.github.com/jerome-dh/'.\Str::random(random_int(10, 15)),
		];
    }

    /**
     * Array of datas <<Illustration>>
     *
     * @return array
     * @throws \Exception
     */
    protected function getIllustration()
    {
         return [
            'image' => 'c'.random_int(1, 5).'.png',
			'experience_id' => Experience::create($this->getExperience())->id,
		];
    }

}
