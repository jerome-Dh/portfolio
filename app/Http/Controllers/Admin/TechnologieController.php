<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\TechnologieRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class TechnologieController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:30
 */
class TechnologieController extends Controller
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
     * The repository for the model Technologie
     *
     * @var TechnologieRepository
     */
    protected  $technologieRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'technologies';

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
     * @param  TechnologieRepository  $technologieRepository
     */
    public function __construct(TechnologieRepository $technologieRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->technologieRepository = $technologieRepository;
    }

    /**
     * List of technologies
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $technologies = $this->technologieRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'technologies.index', compact('technologies'));
    }

    /**
     * Show the form to create a Technologie
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        return view($this->base_view_dir.'technologies.create');
    }

    /**
     * Save a Technologie
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
     * Save or update a Technologie
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerTechnologie($data, $create, $id);

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
                $technologie = $this->technologieRepository->store($data);
                $info = ( ! is_null($technologie)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->technologieRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'technologies/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'technologies/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Technologie
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerTechnologie(array $data, $create, $id = 0)
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
     * Show a specific Technologie
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
     * Get or delete a Technologie
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
            $technologie = $this->technologieRepository->getById($id);
            if($obtain)
            {
                return view($this->base_view_dir.'technologies.show', compact('technologie'));
            }
            else
            {
                $image = $technologie->image;
                if($image) {
                    $this->deleteImage($image);
                }

                $this->technologieRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'technologies.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Technologie introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Technologie for update
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
            $technologie = $this->technologieRepository->getById($id);

            return view($this->base_view_dir.'technologies.edit',
                compact('technologie'));
        }
        else
        {
            $info = 'Technologie introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Technologie
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
     * Delete a Technologie
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
