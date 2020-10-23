<?php
namespace App\Repositories;

use App\Models\{Experience_technologie, Experience, Technologie};

/**
 * Manager class for Experience_technologie model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class Experience_technologieRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Experience_technologie
     */
    public function __construct(Experience_technologie $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Experience_technologie by experience_id
     *
     * @param $value - Value
     *
     * @return Experience_technologie|null
     */
    public function findByExperience_id($value)
    {
        return $this->model->where('experience_id', $value)->first();
    }

    /**
     * Find the experience_technologies
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findExperience_technologie(
        $q = '',
        $sort = 'experience_id',
        $order = 'ASC',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {


            });
        }

        $sort = $sort ? $sort : 'experience_id';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
                    ->paginate($nb, ['*'], 'page', $current);

    }

    /**
     * Get list experiences for select
     *
     * @return array
     */
	public function getExperienceForSelect() {
	    $experiences = [];
	    foreach (Experience::orderBy('year', 'DESC')->get() as $experience) {
	        $experiences[$experience->id] = ucfirst($experience->name_en).' - '.$experience->year;
        }

        return $experiences;
    }
    /**
     * Get list technologies for select
     *
     * @return array
     */
	public function getTechnologieForSelect() {
	    $technologies = [];
	    foreach (Technologie::orderBy('id', 'DESC')->get() as $technologie) {
	        $technologies[$technologie->id] = ucfirst($technologie->name_en);
        }

        return $technologies;
    }
}
