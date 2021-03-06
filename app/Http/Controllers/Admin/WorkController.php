<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\WorkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class WorkController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:30
 */
class WorkController extends Controller
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
     * The repository for the model Work
     *
     * @var WorkRepository
     */
    protected  $workRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'works';

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
     * @param  WorkRepository  $workRepository
     */
    public function __construct(WorkRepository $workRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->workRepository = $workRepository;
    }

    /**
     * List of works
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $works = $this->workRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'works.index', compact('works'));
    }

    /**
     * Show the form to create a Work
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        return view($this->base_view_dir.'works.create');
    }

    /**
     * Save a Work
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
     * Save or update a Work
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerWork($data, $create, $id);

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
                $work = $this->workRepository->store($data);
                $info = ( ! is_null($work)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->workRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'works/'.$uri))
            ->with('info', $info);
        }
        else
        {
            // Validation fails
            return redirect(url($this->base_path.'works/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Work
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an existing identifier
     *
     * @return mixed
     */
    protected function validerWork(array $data, $create, $id = 0)
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

            'title_en' => [
                'nullable',
			    'string',
			    'max:100',
            ],
            'title_fr' => [
                'nullable',
			    'string',
			    'max:100',
            ],
            'description_en' => [
                'nullable',
			    'string',
			    'max:255',
            ],
            'description_fr' => [
                'nullable',
			    'string',
			    'max:255',
            ],
            'image' => [
                'nullable',
			    'image',
            ],
            'source' => [
                'nullable',
			    'string',
			    'max:255',
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Show a specific Work
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
     * Get or delete a Work
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
            $work = $this->workRepository->getById($id);
            if($obtain)
            {
                return view($this->base_view_dir.'works.show', compact('work'));
            }
            else
            {
                $image = $work->image;
                if($image) {
                    $this->deleteImage($image);
                }

                $this->workRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'works.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Work introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Work for update
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
            $work = $this->workRepository->getById($id);

            return view($this->base_view_dir.'works.edit',
                compact('work'));
        }
        else
        {
            $info = 'Work introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Work
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
     * Delete a Work
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
