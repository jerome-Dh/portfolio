<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;

/**
 * Class MakeLibrary
 *
 * @package App\Console\Commands\Core
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 07/03/2020
 */
class MakeLibrary extends Command
{
    /**
     * Trait: helpers
     */
    use Helpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:library';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make all usables libraries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $output_dir = app_path('Library');
        $user_file = $output_dir.'/CommonForUsers.php';
        $custum_file = $output_dir.'/CustomFunction.php';

        $this->checkAndCreateTheOutputDir($output_dir);

        $this->info('En cours ...');
        $this->checkBeforeWrite($user_file, $this->getCommonsUserContent());
        $this->checkBeforeWrite($custum_file, $this->getCustomsFunctionsContent());
        $this->info('Operations terminées avec succes');

        return true;
    }

    protected function getCommonsUserContent() {

        return '<?php

namespace App\Library;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\{User};
use App\Mail\UserMail;

use Carbon\Carbon;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Custums functions for all users
 *
 * @package App\Library
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
trait CommonForUsers
{

    /**
     * Send mail to confirm email address
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
	public function mailConfirmation(User $user)
	{
		//== The token verification
		$token = $this->userRepository->getNextToken();
		$user->remember_token = $token;

		//== Validation time: 24 hours
		$d = new \Datetime();
		$d = $d->setTimestamp(time() + 24 * 3600);
		$user->email_verified_at = $d->getTimestamp();
		$user->save();

		//== Send the mail
		$userMail = new UserMail($user);
		$userMail->setType(\'confirmation_email\')
				->setToken($token);

		Mail::to($user->email)
			->send($userMail);
	}

	/**
     * Validate an email confirmation link
     *
	 * @param string $token - the token
	 *
     * @return User|false
     */
	public function validerEmail(string $token)
	{
		$ret = false;

		if($token)
		{
			$user = $this->userRepository->findByToken($token);

			if($user)
			{
				$now = Carbon::now();
				if($now <= $user->email_verified_at)
				{

					$user->remember_token = \'\';
					$user->statut = config(\'custum.statut.activate\');

					//Sauver en BD
					$user->save();

					$ret = $user;

				}
			}
		}

		return $ret;
	}

	/**
     * Send a mail to user
     *
	 * @param User $user
	 * @param string $password
	 *
     * @return true|false
     */
	public function sendDetailsAccount(User $user, $password=\'\')
	{
		//Envoyer le mail
		$userMail = new UserMail($user);
		$userMail->setType(\'details_compte\')
				->setPassword($password);

		Mail::to($user->email)
			->send($userMail);

		return true;
	}

	/**
     * Send a mail to the user
     *
	 * @param string $token
	 * @param boolean $password - True if password will be generated
	 * @param boolean $matricule
	 *
     * @return array
     */
	public function gererTokenEmail(string $token, $password = false, $matricule = false)
	{
		$ret = [\'content\' => \'\', \'error\' => \'\', \'code\' => 200];

		if(($user = $this->validerEmail($token)))
		{
			// Generate a password and matricule
			$generatedPassword = \'\';
			if($password) {
                $generatedPassword = $this->gererPassword($user);
                $user->password = Hash::make($generatedPassword);
            }

			if($matricule)
				$user->matricule = $this->userRepository->getNextMatricule();

			if($password or $matricule)
				$user->save();

			$this->sendDetailsAccount($user, $generatedPassword);

            $ret[\'user\'] = $user;

			$ret[\'content\'] = \'Adresse email validée avec succès, \'.
				\'un message contenant les données de connexion a été \'.
				\'envoyé !\';

		}
		else
		{
			$ret[\'error\'] = \'Code de vérification invalide ou expiré\';
			$ret[\'code\'] = 400;
		}

		return $ret;
	}

	/**
	 * Generate a password
	 *
	 * @param User $user
	 *
	 * @return string
	 */
	protected function gererPassword(User $user)
	{
		$password = str_shuffle($user->first_name.\'\'.time());
		return $password;
	}

	/**
	 * send a notification to an user
	 *
	 * @param User $user
	 *
	 * @return string - The password
	 */
	protected function changeStatutNotification(User $user)
	{

	}

	/**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            \'access_token\' => $token,
            \'token_type\' => \'bearer\',
            \'expires_in\' => auth()->factory()->getTTL() * 60
        ];
    }

	/**
	 * Delete an user with all his datas
	 *
	 * @param $id - User Identifier
	 */
	protected function deleteAllDataForUser($id)
	{

	}

}';
    }

    /**
     * @return string
     */
    protected function getCustomsFunctionsContent() {

        return '<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

/**
 * Trait CustumFunction
 *
 * @package App\Library
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
trait CustomFunction
{
    /**
     * The upload dir
     *
     * @var string
     */
    protected $dir_images = \'public\';

	/**
	 * Check the keys terms for search
	 *
	 * @param array $datas - datas
	 *
	 *			! [sort] - Champs du classement
	 *			! [order] - ASC/DESC
	 *			! [per] - Nombre de résultats
	 *			! [page] - Numéro de page
	 *
	 * @param array $attr - Attributes list
	 *
	 * @return true|array
	 *
	 */
	public function validerRecherche(array $datas, array $attr = [])
	{
		$ret = true;

		$sort = ($attr) ? [\'required\', Rule::in($attr)] : \'required|string\';

		$tab = [
			\'q\' => \'filled\',
			\'sort\' => $sort,
			\'order\' => [
				\'required\',
				Rule::in([\'asc\', \'desc\', \'ASC\', \'DESC\']),
			],
			\'per\' => \'required|integer\',
			\'page\' => \'required|integer\',
		];

		$validator = Validator::make($datas, $tab);

		if($validator->fails())
		{
			$ret = $validator->errors();
		}

		return $ret;
	}

	/**
	 * Check id existence for non-session
	 *
	 * @param $id - Identifier
	 * @param $table - Table name
	 *
	 * @return array|true
	 */
	protected function validerId($id, $table) {

		if($id) {
			$validator = Validator::make(
			[\'id\' => $id],
			[
				\'id\' => [
					\'required\',
					\'numeric\',
					Rule::exists($table)->where(function ($query) use ($id) {
						$query->where(\'id\', $id);
					}),
				],
			]);

			if($validator->fails()) {
				$ret = $validator->errors();
			}
			else {
				$ret = true;
			}
		}
		else {
			$ret = [\'id\' => \'Champ [id] doit avoir une valeur\'];
		}

		return $ret;
	}

    /**
     * Check an id existence for session
     *
     * @param $id - Identifier
     * @param $table - Table name
     *
     * @return mixed
     */
    protected function validerIdSession($id, $table)
    {
        $validator = Validator::make(
            [\'id\' => $id],
            [
                \'id\' => [
                    \'required\',
                    \'numeric\',
                    Rule::exists($table)->where(function ($query) use ($id) {
                        $query->where(\'id\', $id);
                    }),
                ],
            ]);

        return $validator->fails() ? $validator : true;
    }

    /**
     * Check the plage of a date
     *
     * @param \Datetime $debut
     * @param \Datetime @fin
     *
     * @return true|false
     * @throws \Exception
     */
	protected function validePlage($debut, $fin)
	{
		$tab = [
			\'debut\' => $debut,
			\'fin\' => $fin,
		];
		$validator = Validator::make($tab, [
			\'debut\' => \'required|date\',
			\'fin\' => \'required|date\',
		]);

		if( ! $validator->fails()) {

			$d = new Carbon($debut);
			$f = new Carbon($fin);

			return $d < $f;
		}

		return false;
	}

    /**
     * Check an array of products
     *
     * @param array $produits
     *
     * @return bool|\Illuminate\Support\MessageBag
     */
	protected function validerTableauProduits(array $produits)
	{
		$tab = [
			\'produits\' => \'required|array\',
			\'produits.*.id\' => [
				\'required\',
				\'integer\',
				\'exists:produits,id\',
			],
			\'produits.*.qte\' => [
				\'required\',
				\'integer\',
				\'min:1\',
			],
		];

		$validator = Validator::make($produits, $tab);
		return ($validator->fails()) ? $validator->errors() : true;
	}


    /**
     * Save an image
     *
     * @param $datas
     * @return string|false
     */
    public function createImage(array $datas)
    {
        $image = $datas[\'image\'];
        // Log::error($image);

        if ($image->isValid()) {
            //Generate an unique id
            $ret = $image->store($this->dir_images);

			// Substract the "public/" preffix
			$ret = substr($ret, strlen($this->dir_images.\'/\'));
        }
        else {
            $ret = false;
        }

        return $ret;
    }

    /**
     * Delete an image
     *
     * @param string $name
     * @return bool
     */
    public function deleteImage(string $name)
    {
        if(Storage::exists(($this->dir_images.\'/\'.$name))) {
            Storage::delete($this->dir_images.\'/\'.$name);
            $ret = true;
        }
        else {
            $ret = false;
        }

        return $ret;
    }

    /**
     * Check the request and save associated image
     *
     * @param array $data
     * @return array
     */
    public function checkAndSaveImage(array $data) {

        $ret  = [];
        if(array_key_exists(\'image\', $data) and $data[\'image\'])  {

            $name = $this->createImage([\'image\' => $data[\'image\']]);
            if($name != false) {
                $ret = [\'image\' => $name];
            }
        }

        return $ret;
    }

}';

    }

}
