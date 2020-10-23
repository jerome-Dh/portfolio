<?php
namespace App\Http\Controllers\Admin;

use App\Library\CommonForUsers;
use App\Library\CustomFunction;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:26
 */
class UserController extends Controller
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
     * The repository for the model User
     *
     * @var UserRepository
     */
    protected  $userRepository;

    /**
     * Name of the DB table
     * @var string
     */
    protected $table = 'users';

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
     * @param  UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        //The middlewares
        $this->middleware('auth');
        $this->middleware('admin');

        $this->userRepository = $userRepository;
    }

    /**
     * List of users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// Log::alert('index: ');
        $users = $this->userRepository->getPaginateByOrder('id', $this->nbPerPage);
        return view($this->base_view_dir.'users.index', compact('users'));
    }

    /**
     * Show the form to create a User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		// Log::alert('create: ');
        return view($this->base_view_dir.'users.create');
    }

    /**
     * Save a User
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
     * Save or update a User
     *
     * @param Request $request
     * @param $create
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function saveOrUpdate(Request $request, $create, $id)
    {
        $data = $request->all();
        $validator = $this->validerUser($data, $create, $id);

        $uri = $create ? 'create' : $id.'/edit';

        if($validator === true)
        {
             $data = array_merge(
                $data,
                ['author_id' => $request->user()->id],
                $this->checkAndSaveImage($data)
            );

            if(array_key_exists('password', $data)) {
                $data['password'] = Hash::make($data['password']);
            }

            if($create)
            {
                $user = $this->userRepository->store($data);
                $info = ( ! is_null($user)) ? 'Sauvegarde effectuée avec succès !'
                    : 'Une erreur est survenue lors de la sauvegarde, veuillez réessayer !';
            }
            else
            {
                $this->userRepository->update($id, $data);
                $info = 'Mise à jour effectuée avec succès';
            }

            return redirect(url($this->base_path.'users/'.$uri))
            ->with('info', $info);
        }
        else
        {
            //Echec de validation
            return redirect(url($this->base_path.'users/'.$uri))
                ->withErrors($validator)
                ->withInput();
        }

    }

    /**
     * Validate a User
     *
     * @param array $data
     * @param boolean $create - Create/Update
     * @param $id - an exists identifier
     *
     * @return mixed
     */
    protected function validerUser(array $data, $create, $id = 0)
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

                'email' => [
                    'required',
					'email',
					Rule::unique($this->table)->ignore($id),
                ],
            ];
        }
        else
        {
            $tab1 = [

                'email' => [
                    'required',
					'email',
					Rule::unique($this->table),
                ],
            ];
        }

        $tab2 = [

            'name' => [
                'required',
			    'string',
			    'max:100',
            ],
            'password' => [
                'required',
			    'string',
			    'max:100',
            ],
            'role' => [
                'required',
			    Rule::in(config('custum.user_role')),
            ],
        ];

        $tab = array_merge($tab1, $tab2);
        $validator = Validator::make($data, $tab);

        return $validator->fails() ? $validator : true;

    }

    /**
     * Show a specific User
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
     * Get or delete a User
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
                $user = $this->userRepository->getById($id);
                return view($this->base_view_dir.'users.show', compact('user'));
            }
            else
            {
                $this->userRepository->destroy($id);
                $info = 'Suppression effectuée avec succès';
                return redirect(route($this->base_view_dir.'users.index'))
					->with('info', $info);
            }
        }
        else
        {
            $info = 'User introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Show a User for update
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
            $user = $this->userRepository->getById($id);

            return view($this->base_view_dir.'users.edit',
                compact('user'));
        }
        else
        {
            $info = 'User introuvable !';
            return back()
                ->with('info', $info);
        }

    }

    /**
     * Update a User
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
     * Delete a User
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
