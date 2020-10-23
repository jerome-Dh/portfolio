<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 *
 * Class MakeRepository
 * Construire un outil de génération de répository
 *
 * @package App\Console\Commands\Core
 * @date 16/07/2019
 * @author Jerome Dh <jdieuhou@gmail.com>
 */
class MakeRepository extends Command
{

	/**
	 * Trait des utilitaires
	 *
	 * @Trait Helpers
	 */
	 use Helpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:repository
							{--c|classe=all : To generated the repository for classe}';

    /**
     * The console command description.
     *
     * @var string
     */
	protected $description = 'Create a repository for model';

    /**
     * Array of all classes
     *
     * @var array
     */
	protected $tabClasses = [];

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
        $output_dir = app_path('Repositories');

        $dirname = database_path('migrations');
        try {
            //Retrieve the argument value
            $classe = $this->option('classe');
            $reader = new Reader($dirname);

            if ($classe == 'all') {
                $tabClasses = $reader->getAllClasses();
            } else {
                $tabClasses = $reader->getOnlyClasses([$classe]);
            }

            $this->tabClasses = $reader->getAllClasses();
            $this->traitement($tabClasses, $output_dir, 'repository');

        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());
        } finally {

            $resource_file = $output_dir.'/ResourceRepository.php';
            $response_file = $output_dir.'/ResponseRepository.php';

            if ($classe == 'all') {
                $this->info('En cours ...');
                $this->checkBeforeWrite($resource_file, $this->getResourceContent());
                $this->checkBeforeWrite($response_file, $this->getResponseContent());
                $this->info('Operations terminées avec succes');
            }

        }

        return true;
    }

    /**
     * @return string
     */
    protected function getResourceContent() {

        return '<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Log;

/**
 * Resource Repository class
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
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
        return $this->model->orderBy($order, \'desc\')->paginate($nbPerPage);
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
     * @return mixed
     */
	public function getById($id)
	{
		//return $this->model->findOrFail($id);
		return $this->model->find($id);
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

}';
    }

    /**
     * @return string
     */
    protected function getResponseContent() {
        return '<?php
namespace App\Repositories;

/**
 * ResponseRepository class
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
class ResponseRepository
{
	private $url = null;
	private $date = null;
	private $time = null;
	private $statut = null;
	private $response = null;
	private $error = null;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->setUrl(url(\'/\'));
		$this->setDate(date(\'Y-m-d\', time()));
		$this->setTime(date(\'H:i:s\', time()));
	}

	/**
	 * JSON Response
	 *
	 * @param $codeHttp - Code de statut
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function make($content, $error,  $codeHttp = 200, $url = \'\')
	{
		$this->setResponse($content);
		$this->setError($error);
		$this->setUrl($url);

		return response()->json(
			[
				\'url\' => $this->getUrl(),
				\'date\' => $this->getDate(),
				\'time\' => $this->getTime(),
				\'statut\' => $codeHttp,
				\'response\' => $this->getResponse(),
				\'error\' => $this->getError(),
			], $codeHttp);
	}

	//==== Getter ====

	public function getUrl()
	{
		return $this->url;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function getstatut()
	{
		return $this->statut;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function getError()
	{
		return $this->error;
	}


	//==== Setter ====

	public function setUrl($url)
	{
		if( ! empty($url))
			$this->url = $url;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setTime($time)
	{
		$this->time = $time;
	}

	public function setstatut($statut)
	{
		$this->statut = $statut;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}

	public function setError($error)
	{
		$this->error = $error;
	}

}';

    }

    /**
     * Récupérer la chaine à écrire dans le fichier
     *
     * @param $name - Nom de la classe
     * @param array $datas
     * @return string
     */
	protected function getContent($name, array $datas)
	{
		$lowerName = strtolower($name);
		$upperName = ucfirst($name);

        return '<?php
namespace App\Repositories;

use App\Models\\{'.$upperName.''.$this->getRelationalTableName($datas, true).'};

/**
 * Manager class for '.$upperName.' model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
class '.$upperName.'Repository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - '.$upperName.'
     */
    public function __construct('.$upperName.' $model)
    {
        $this->model = $model;
    }

    /**
     * Find a '.$upperName.' by '.$this->getFirstKeyName($datas).'
     *
     * @param $value - Value
     *
     * @return '.$upperName.'|null
     */
    public function findBy'.ucfirst($this->getFirstKeyName($datas)).'($value)
    {
        return $this->model->where(\''.$this->getFirstKeyName($datas).'\', $value)->first();
    }

    /**
     * Find the '.$lowerName.'s
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function find'.$upperName.'(
        $q = \'\',
        $sort = \''.$this->getFirstKeyName($datas).'\',
        $order = \'ASC\',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {
                '.$this->getSearchWhere($datas).'

            });
        }

        $sort = $sort ? $sort : \''.$this->getFirstKeyName($datas).'\';
        $order = $order ? $order : \'ASC\';

        return $clone->orderBy($sort, $order)
            ->paginate($nb, [\'*\'], \'page\', $current);
    }
    '.$this->getRelationalListSelect($datas).'
}';

	}

    /**
     * Get the list of select for relationals tables
     *
     * @param array $datas
     * @return string
     */
	protected function getRelationalListSelect(array $datas) : string {
        $ret = '';
        foreach($this->getRelationalsTablesNames($datas) as $otherClasse) {

            $otherDatas = $this->getDatasForClassName(ucfirst($otherClasse).'s', $this->tabClasses);
            $otherFirstKey = $otherDatas ? $this->getFirstKeyName($otherDatas) : 'name';

            $ret .= '
    /**
     * Get list '.$otherClasse.'s for select
     *
     * @return array
     */
	public function get'.ucfirst($otherClasse).'ForSelect() {
	    $'.$otherClasse.'s = [];
	    foreach ('.ucfirst($otherClasse).'::orderBy(\'id\', \'DESC\')->get() as $'.$otherClasse.') {
	        $'.$otherClasse.'s[$'.$otherClasse.'->id] = ucfirst($'.$otherClasse.'->'.$otherFirstKey.');
        }

        return $'.$otherClasse.'s;
    }';
        }

        return $ret;
    }

}
