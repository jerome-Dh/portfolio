<?php
namespace App\Repositories;

use App\Models\{Work};

/**
 * Manager class for Work model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:43
 */
class WorkRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Work
     */
    public function __construct(Work $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Work by name_en
     *
     * @param $value - Value
     *
     * @return Work|null
     */
    public function findByName_en($value)
    {
        return $this->model->where('name_en', $value)->first();
    }

    /**
     * Find the works
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findWork(
        $q = '',
        $sort = 'name_en',
        $order = 'ASC',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {

				$query->where('name_en', 'LIKE', '%'.$q.'%')
					->orWhere('name_fr', 'LIKE', '%'.$q.'%')
					->orWhere('title_en', 'LIKE', '%'.$q.'%')
					->orWhere('title_fr', 'LIKE', '%'.$q.'%')
					->orWhere('description_en', 'LIKE', '%'.$q.'%')
					->orWhere('description_fr', 'LIKE', '%'.$q.'%')
					->orWhere('image', 'LIKE', '%'.$q.'%')
					->orWhere('source', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'name_en';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
            ->paginate($nb, ['*'], 'page', $current);

    }

    /**
     * Get all Works
     *
     * @param string $order
     * @return mixed
     */
    public function getAllWorks($order = 'DESC')
    {
        return $this->model->orderBy('id', $order)->get();
    }

}
