<?php

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
 * @date 05/10/2020 20:53
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
		$userMail->setType('confirmation_email')
				->setToken($token);

		Mail::to($user->email)
			->send($userMail);
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
		$ret = ['content' => '', 'error' => '', 'code' => 200];

		if(($user = $this->validerEmail($token)))
		{
			// Generate a password and matricule
			$generatedPassword = '';
			if($password) {
                $generatedPassword = $this->gererPassword($user);
                $user->password = Hash::make($generatedPassword);
            }

			if($matricule)
				$user->matricule = $this->userRepository->getNextMatricule();

			if($password or $matricule)
				$user->save();

			$this->sendDetailsAccount($user, $generatedPassword);

            $ret['user'] = $user;

			$ret['content'] = 'Adresse email validée avec succès, '.
				'un message contenant les données de connexion a été '.
				'envoyé !';

		}
		else
		{
			$ret['error'] = 'Code de vérification invalide ou expiré';
			$ret['code'] = 400;
		}

		return $ret;
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

					$user->remember_token = '';
					$user->statut = config('custum.statut.activate');

					//Sauver en BD
					$user->save();

					$ret = $user;

				}
			}
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
		$password = str_shuffle($user->first_name.''.time());
		return $password;
	}

	/**
     * Send a mail to user
     *
	 * @param User $user
	 * @param string $password
	 *
     * @return true|false
     */
	public function sendDetailsAccount(User $user, $password='')
	{
		//Envoyer le mail
		$userMail = new UserMail($user);
		$userMail->setType('details_compte')
				->setPassword($password);

		Mail::to($user->email)
			->send($userMail);

		return true;
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
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

}
