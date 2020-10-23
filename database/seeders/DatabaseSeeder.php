<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ExperienceSeeder::class);
        $this->call(TechnologieSeeder::class);
        $this->call(Experience_technologieSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(Module_skillSeeder::class);
        $this->call(WorkSeeder::class);
        $this->call(IllustrationSeeder::class);
    }

}
