<?php
namespace App\Repositories;

use App\Models\{Experience};

/**
 * Manager class for Experience model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class ExperienceRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Experience
     */
    public function __construct(Experience $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Experience by year
     *
     * @param $value - Value
     *
     * @return Experience|null
     */
    public function findByYear($value)
    {
        return $this->model->where('year', $value)->first();
    }

    /**
     * Find the experiences
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findExperience(
        $q = '',
        $sort = 'year',
        $order = 'ASC',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {

				$query->where('year', 'LIKE', '%'.$q.'%')
					->orWhere('name_en', 'LIKE', '%'.$q.'%')
					->orWhere('name_fr', 'LIKE', '%'.$q.'%')
					->orWhere('description_en', 'LIKE', '%'.$q.'%')
					->orWhere('description_fr', 'LIKE', '%'.$q.'%')
					->orWhere('image', 'LIKE', '%'.$q.'%')
					->orWhere('source', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'year';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
                    ->paginate($nb, ['*'], 'page', $current);

    }

    /**
     * Get all experiences ordering by year
     *
     * @param string $order
     * @return array
     */
    public function getByYear(string $order = 'DESC')
    {
        $years =  $this->model->distinct('year')->orderby('year', $order)->get('year');
        $result = [];

        foreach ($years as $year)
        {
            $result[$year->year] = $this->model->where('year', $year->year)->get();
        }

        return $result;

    }

}
