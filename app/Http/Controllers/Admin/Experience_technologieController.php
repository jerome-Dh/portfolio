<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\Experience_technologieRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class Experience_technologieController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:30
 */
class Experience_technologieController extends Controller
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
     * The repository for the model Experience_technologie
     *
     * @var Experience_technologieRepository
     */
    protected  $experience_technologieRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'experience_technologie';

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
     * @param  Experience_technologieRepository  $experience_technologieRepository
     */
    public function __construct(Experience_technologieRepository $experience_technologieRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->experience_technologieRepository = $experience_technologieRepository;
    }

    /**
     * List of experience_technologies
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $experience_technologies = $this->experience_technologieRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'experience_technologies.index', compact('experience_technologies'));
    }

    /**
     * Show the form to create a Experience_technologie
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        $experiences = $this->experience_technologieRepository->getExperienceForSelect();
        $technologies = $this->experience_technologieRepository->getTechnologieForSelect();
        return view($this->base_view_dir.'experience_technologies.create',
            compact('experiences', 'technologies'));
    }

    /**
     * Save a Experience_technologie
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
     * Save or update a Experience_technologie
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerExperience_technologie($data, $create, $id);

        $uri = $create ? 'create' : $id.'/edit';

        if($validator === true)
        {
            if($create)
            {
                $experience_technologie = $this->experience_technologieRepository->store($data);
                $info = ( ! is_null($experience_technologie)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->experience_technologieRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'experience_technologies/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'experience_technologies/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Experience_technologie
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerExperience_technologie(array $data, $create, $id = 0)
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

            'experience_id' => [
                'required',
			    'numeric',
                'exists:experiences,id',
            ],
            'technologie_id' => [
                'required',
			    'numeric',
                'exists:technologies,id',
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Show a specific Experience_technologie
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
     * Get or delete a Experience_technologie
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
                $experience_technologie = $this->experience_technologieRepository->getById($id);
                return view($this->base_view_dir.'experience_technologies.show', compact('experience_technologie'));
            }
            else
            {
                $this->experience_technologieRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'experience_technologies.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Experience_technologie introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Experience_technologie for update
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
            $experience_technologie = $this->experience_technologieRepository->getById($id);

            $experiences = $this->experience_technologieRepository->getExperienceForSelect();
            $technologies = $this->experience_technologieRepository->getTechnologieForSelect();
            return view($this->base_view_dir.'experience_technologies.edit',
                compact('experience_technologie', 'experiences', 'technologies'));
        }
        else
        {
            $info = 'Experience_technologie introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Experience_technologie
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
     * Delete a Experience_technologie
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
