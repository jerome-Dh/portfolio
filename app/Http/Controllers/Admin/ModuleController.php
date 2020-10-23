<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class ModuleController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:30
 */
class ModuleController extends Controller
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
     * The repository for the model Module
     *
     * @var ModuleRepository
     */
    protected  $moduleRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'modules';

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
     * @param  ModuleRepository  $moduleRepository
     */
    public function __construct(ModuleRepository $moduleRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->moduleRepository = $moduleRepository;
    }

    /**
     * List of modules
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $modules = $this->moduleRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'modules.index', compact('modules'));
    }

    /**
     * Show the form to create a Module
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        return view($this->base_view_dir.'modules.create');
    }

    /**
     * Save a Module
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
     * Save or update a Module
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerModule($data, $create, $id);

        $uri = $create ? 'create' : $id.'/edit';

        if($validator === true)
        {
             $data = array_merge(
                $data,
                ['author_id' => $request->user()->id],
                $this->checkAndSaveImage($data)
            );

            if($create)
            {
                $module = $this->moduleRepository->store($data);
                $info = ( ! is_null($module)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->moduleRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'modules/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'modules/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Module
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerModule(array $data, $create, $id = 0)
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

                'name_en' => [
                    'required',
					'string',
                    'max:100',
					Rule::unique($this->table)->ignore($id),
                ],
                'name_fr' => [
                    'required',
					'string',
                    'max:100',
					Rule::unique($this->table)->ignore($id),
                ],
            ];
        }
        else
        {
            $tab1 = [

                'name_en' => [
                    'required',
					'string',
                    'max:100',
					Rule::unique($this->table),
                ],
                'name_fr' => [
                    'required',
					'string',
                    'max:100',
					Rule::unique($this->table),
                ],
            ];
        }

        $tab2 = [

            'leved' => [
                'nullable',
			    'integer',
            ],
            'image' => [
                'nullable',
			    'image',
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Show a specific Module
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
     * Get or delete a Module
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
            $module = $this->moduleRepository->getById($id);
            if($obtain)
            {
                return view($this->base_view_dir.'modules.show', compact('module'));
            }
            else
            {
                $image = $module->image;
                if($image) {
                    $this->deleteImage($image);
                }

                $this->moduleRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'modules.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Module introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Module for update
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
            $module = $this->moduleRepository->getById($id);

            return view($this->base_view_dir.'modules.edit',
                compact('module'));
        }
        else
        {
            $info = 'Module introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Module
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
     * Delete a Module
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
