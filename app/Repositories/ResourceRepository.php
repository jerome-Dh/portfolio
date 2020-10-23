<?php
namespace App\Repositories;


/**
 * Resource Repository class
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
abstract class ResourceRepository
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
	protected $model;

    /**
     * @param $n
     * @return mixed
     */
	public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}

	/**
     * Paginer par ordre
     *
     * @param $order
     * @param $nbPerPage
     * @return mixed
     */
	public function getPaginateByOrder($order, $nbPerPage)
    {
        return $this->model->orderBy($order, 'desc')->paginate($nbPerPage);
    }

    /**
     * @param array $inputs
     * @return mixed
     */
	public function store(array $inputs)
	{
		return $this->model->create($inputs);
	}

    /**
     * @param $id
     * @param array $inputs
     * @return void
     */
	public function update($id, array $inputs)
	{
		$m = $this->getById($id);
		if( ! is_null($m))
		{
			$m->update($inputs);
		}
	}

    /**
     * @param $id
     * @return mixed
     */
	public function getById($id)
	{
		return $this->model->find($id);
	}

    /**
     * @param $id
     * @return void
     */
	public function destroy($id)
	{
		if(($m = $this->getById($id)))
		{
			$m->delete();
		}
	}

    /**
     * Récupérer le model en cours
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
	public function getModel()
	{
		return $this->model;
	}

}
