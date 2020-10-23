<?php
namespace App\Repositories;

use App\Models\{Technologie};

/**
 * Manager class for Technologie model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class TechnologieRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Technologie
     */
    public function __construct(Technologie $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Technologie by name_en
     *
     * @param $value - Value
     *
     * @return Technologie|null
     */
    public function findByName($value)
    {
        return $this->model->where('name_en', $value)->first();
    }

    /**
     * Find the technologies
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findTechnologie(
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
					->orWhere('image', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'name_en';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
            ->paginate($nb, ['*'], 'page', $current);
    }

}
