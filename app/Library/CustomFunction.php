<?php

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
 * @date 05/10/2020 20:53
 */
trait CustomFunction
{
    /**
     * The upload dir
     *
     * @var string
     */
    protected $dir_images = 'public';

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

		$sort = ($attr) ? ['required', Rule::in($attr)] : 'required|string';

		$tab = [
			'q' => 'filled',
			'sort' => $sort,
			'order' => [
				'required',
				Rule::in(['asc', 'desc', 'ASC', 'DESC']),
			],
			'per' => 'required|integer',
			'page' => 'required|integer',
		];

		$validator = Validator::make($datas, $tab);

		if($validator->fails())
		{
			$ret = $validator->errors();
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
        if(Storage::exists(($this->dir_images.'/'.$name))) {
            Storage::delete($this->dir_images.'/'.$name);
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
        if(array_key_exists('image', $data) and $data['image'])  {

            $name = $this->createImage(['image' => $data['image']]);
            if($name != false) {
                $ret = ['image' => $name];
            }
        }

        return $ret;
    }

    /**
     * Save an image
     *
     * @param $datas
     * @return string|false
     */
    public function createImage(array $datas)
    {
        $image = $datas['image'];
        // Log::error($image);

        if ($image->isValid()) {

            //Generate an unique id
            $ret = $image->store($this->dir_images);
			$ret = basename($ret);

			// Only for 000webhostapp.com server that doesn't support symlink
            $this->moveToPublicDir($ret);

        }
        else {
            $ret = false;
        }

        return $ret;
    }

    /**
     * Hit: Move from storage/app/public/ to public/storage/
     * @param $filename
     */
    public function moveToPublicDir($filename)
    {
        if(file_exists(base_path('/storage/app/public/'.$filename)))
        {
            rename (base_path('storage/app/public/'.$filename), base_path('public/storage/'.$filename));
        }
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
			['id' => $id],
			[
				'id' => [
					'required',
					'numeric',
					Rule::exists($table)->where(function ($query) use ($id) {
						$query->where('id', $id);
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
			$ret = ['id' => 'Champ [id] doit avoir une valeur'];
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
            ['id' => $id],
            [
                'id' => [
                    'required',
                    'numeric',
                    Rule::exists($table)->where(function ($query) use ($id) {
                        $query->where('id', $id);
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
			'debut' => $debut,
			'fin' => $fin,
		];
		$validator = Validator::make($tab, [
			'debut' => 'required|date',
			'fin' => 'required|date',
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
			'produits' => 'required|array',
			'produits.*.id' => [
				'required',
				'integer',
				'exists:produits,id',
			],
			'produits.*.qte' => [
				'required',
				'integer',
				'min:1',
			],
		];

		$validator = Validator::make($produits, $tab);
		return ($validator->fails()) ? $validator->errors() : true;
	}

}
