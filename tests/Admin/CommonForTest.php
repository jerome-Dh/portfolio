<?php

namespace Tests\Admin;

use Database\Seeders\CommonForSeeders;
use App\Models\{User};

 /**
 * Trait CommonForTest
 * Share methods to all tests
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
trait CommonForTest
{
    /**
     * @Trait CommonForSeeders
     */
    use CommonForSeeders;

	/**
	 * Base url
	 *
	 * @var String
	 */
	protected $base_url = 'http://127.0.0.1:8000/admin';

	/**
	 * Print an response
	 *
	 * @param $response
	 */
	protected function printResponse($response)
	{
		print_r($response->baseResponse->original);
	}

    /**
     * Insert some users in the DB
     * @throws \Exception
     */
	protected function insertUsers()
	{
		//Raser la table
		User::truncate();

		//Insérer 10 données
		for($i = 0; $i<10; ++$i)
		{
            User::create($this->getUser());
		}
	}

    /**
     * Create an admin
     *
     * @return mixed
     * @throws \Exception
     */
    protected function createAdmin()
    {
        $user = $this->getUser();
        $user['role'] = config('custum.user_role.admin');
        return User::create($user);
    }

}
