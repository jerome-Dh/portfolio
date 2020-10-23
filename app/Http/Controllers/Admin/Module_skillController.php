<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\Module_skillRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class Module_skillController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:30
 */
class Module_skillController extends Controller
{
    /**
     * Trait of utilities functions
     *
     * @trait CustomFunction
     */
    use CustomFunction;

    /**
     * Trait for commons operations
     *
     * @trait CommonForUsers
     */
    use CommonForUsers;

    /**
     * The repository for the model Module_skill
     *
     * @var Module_skillRepository
     */
    protected  $module_skillRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'module_skill';

    /**
     * Path and base dir
     */
    protected $base_view_dir = 'admin.';
    protected $base_path = 'admin/';

    /**
     * Number of pages elements
     * @var int
     */
    protected $nbPerPage = 10;

    /**
     * Constructor
     *
     * @param  Module_skillRepository  $module_skillRepository
     */
    public function __construct(Module_skillRepository $module_skillRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->module_skillRepository = $module_skillRepository;
    }

    /**
     * List of module_skills
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $module_skills = $this->module_skillRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'module_skills.index', compact('module_skills'));
    }

    /**
     * Show the form to create a Module_skill
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        $modules = $this->module_skillRepository->getModuleForSelect();
        $skills = $this->module_skillRepository->getSkillForSelect();
        return view($this->base_view_dir.'module_skills.create',
            compact('modules', 'skills'));
    }

    /**
     * Save a Module_skill
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
		// Log::alert('store: ');
		return $this->saveOrUpdate($request, true, 0);
    }

    /**
     * Save or update a Module_skill
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerModule_skill($data, $create, $id);

        $uri = $create ? 'create' : $id.'/edit';

        if($validator === true)
        {
            if($create)
            {
                $module_skill = $this->module_skillRepository->store($data);
                $info = ( ! is_null($module_skill)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->module_skillRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'module_skills/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'module_skills/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Module_skill
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerModule_skill(array $data, $create, $id = 0)
    {
        //Check the existence of $id in table
        if( ! $create)
        {
            $validId = $this->validerIdSession($id, $this->table);

            if($validId !== true)
            {
                return $validId;
            }
            $tab1 = [

            ];
        }
        else
        {
            $tab1 = [

            ];
        }

        $tab2 = [

            'module_id' => [
                'required',
			    'numeric',
                'exists:modules,id',
            ],
            'skill_id' => [
                'required',
			    'numeric',
                'exists:skills,id',
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Show a specific Module_skill
     *
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
		// Log::alert('show: ' . $id);
        return $this->obtainOrDelete(true, $id);
    }

    /**
     * Get or delete a Module_skill
     *
     * @param $obtain
     * @param $id
     * @return mixed
     */
    protected function obtainOrDelete($obtain, $id)
    {
        $validator = $this->validerIdSession($id, $this->table);

        if($validator === true)
        {
            if($obtain)
            {
                $module_skill = $this->module_skillRepository->getById($id);
                return view($this->base_view_dir.'module_skills.show', compact('module_skill'));
            }
            else
            {
                $this->module_skillRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'module_skills.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Module_skill introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Module_skill for update
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
		// Log::alert('edit: ' . $id);
        $validator = $this->validerIdSession($id, $this->table);

        if($validator === true)
        {
            $module_skill = $this->module_skillRepository->getById($id);

            $modules = $this->module_skillRepository->getModuleForSelect();
            $skills = $this->module_skillRepository->getSkillForSelect();
            return view($this->base_view_dir.'module_skills.edit',
                compact('module_skill', 'modules', 'skills'));
        }
        else
        {
            $info = 'Module_skill introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Module_skill
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
		// Log::alert('update: ' . $id);
        return $this->saveOrUpdate($request, false, $id);
    }

    /**
     * Delete a Module_skill
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function destroy($id)
    {
        // Log::alert('destroy: ' . $id);
        return $this->obtainOrDelete(false, $id);
    }

    /**
     * Zone to remove, just for the tests
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        $url = $request->fullUrl();
        return response($url);
    }

}
