<?php
namespace App\Repositories;

use App\Models\{Module_skill, Module, Skill};

/**
 * Manager class for Module_skill model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class Module_skillRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Module_skill
     */
    public function __construct(Module_skill $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Module_skill by module_id
     *
     * @param $value - Value
     *
     * @return Module_skill|null
     */
    public function findByModule_id($value)
    {
        return $this->model->where('module_id', $value)->first();
    }

    /**
     * Find the module_skills
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findModule_skill(
        $q = '',
        $sort = 'module_id',
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

        $sort = $sort ? $sort : 'module_id';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
                    ->paginate($nb, ['*'], 'page', $current);

    }
    
    /**
     * Get list modules for select
     *
     * @return array
     */
	public function getModuleForSelect() {
	    $modules = [];
	    foreach (Module::orderBy('id', 'DESC')->get() as $module) {
	        $modules[$module->id] = ucfirst($module->name_en);
        }

        return $modules;
    }
    /**
     * Get list skills for select
     *
     * @return array
     */
	public function getSkillForSelect() {
	    $skills = [];
	    foreach (Skill::orderBy('id', 'DESC')->get() as $skill) {
	        $skills[$skill->id] = ucfirst($skill->name_en);
        }

        return $skills;
    }
}