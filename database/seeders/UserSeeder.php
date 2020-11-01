<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User};

/**
 * Class UserSeeder
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 22:20
 */
class UserSeeder extends Seeder
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
//        for($i = 0; $i < 20; $i++) {
//            $user = $this->getUser();
//            User::create($user);
//        }

        User::create([
            'name' => 'Jerome Dh',
            'email' => 'jdieuhou@gmail.com',
            'password' => Hash::make('78123456'),
            'role' => config('custum.user_role.admin'),
        ]);

    }

}
