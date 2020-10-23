<?php
namespace App\Repositories;

use App\Models\{Skill};

/**
 * Manager class for Skill model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class SkillRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Skill
     */
    public function __construct(Skill $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Skill by name_en
     *
     * @param $value - Value
     *
     * @return Skill|null
     */
    public function findByName_en($value)
    {
        return $this->model->where('name_en', $value)->first();
    }

    /**
     * Find the skills
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findSkill(
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
					->orWhere('subname_en', 'LIKE', '%'.$q.'%')
					->orWhere('subname_fr', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'name_en';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
                    ->paginate($nb, ['*'], 'page', $current);

    }


    /**
     * Get all skills
     *
     * @param string $order
     * @return mixed
     */
    public function getAllSkills($order = 'DESC')
    {
        return $this->model->orderBy('id', $order)->get();
    }

}
