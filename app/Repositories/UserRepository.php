<?php
namespace App\Repositories;

use App\Models\{User};

/**
 * Manager class for User model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class UserRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - User
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Find a User by name
     *
     * @param $value - Value
     *
     * @return User|null
     */
    public function findByName($value)
    {
        return $this->model->where('name', $value)->first();
    }

    /**
     * Find the users
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findUser(
        $q = '',
        $sort = 'name',
        $order = 'ASC',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {

				$query->where('name', 'LIKE', '%'.$q.'%')
					->orWhere('email', 'LIKE', '%'.$q.'%')
					->orWhere('email_verified_at', 'LIKE', '%'.$q.'%')
					->orWhere('password', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'name';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
            ->paginate($nb, ['*'], 'page', $current);
    }

}
