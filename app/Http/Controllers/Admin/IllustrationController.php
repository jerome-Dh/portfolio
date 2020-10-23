<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\IllustrationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class IllustrationController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:26
 */
class IllustrationController extends Controller
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
     * The repository for the model Illustration
     *
     * @var IllustrationRepository
     */
    protected  $illustrationRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'illustrations';

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
     * @param  IllustrationRepository  $illustrationRepository
     */
    public function __construct(IllustrationRepository $illustrationRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->illustrationRepository = $illustrationRepository;
    }

    /**
     * List of illustrations
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $illustrations = $this->illustrationRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'illustrations.index', compact('illustrations'));
    }

    /**
     * Show the form to create a Illustration
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
            $experiences = $this->illustrationRepository->getExperienceForSelect();
        return view($this->base_view_dir.'illustrations.create',
            compact('experiences'));
    }

    /**
     * Save a Illustration
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
     * Save or update a Illustration
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerIllustration($data, $create, $id);

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
                $illustration = $this->illustrationRepository->store($data);
                $info = ( ! is_null($illustration)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->illustrationRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'illustrations/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'illustrations/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a Illustration
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerIllustration(array $data, $create, $id = 0)
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

            'image' => [
                'nullable',
			    'image',
            ],
            'experience_id' => [
                'required',
			    'numeric',
                'exists:experiences,id',
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Show a specific Illustration
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
     * Get or delete a Illustration
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
            $illustration = $this->illustrationRepository->getById($id);
            if($obtain)
            {
                return view($this->base_view_dir.'illustrations.show', compact('illustration'));
            }
            else
            {
                $image = $illustration->image;
                if($image) {
                    $this->deleteImage($image);
                }

                $this->illustrationRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'illustrations.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'Illustration introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a Illustration for update
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
            $illustration = $this->illustrationRepository->getById($id);

            $experiences = $this->illustrationRepository->getExperienceForSelect();
            return view($this->base_view_dir.'illustrations.edit',
                compact('illustration', 'experiences'));
        }
        else
        {
            $info = 'Illustration introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a Illustration
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
     * Delete a Illustration
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
