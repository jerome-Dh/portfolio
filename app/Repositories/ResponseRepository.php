<?php
namespace App\Repositories;

/**
 * ResponseRepository class
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
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
		$this->setUrl(url('/'));
		$this->setDate(date('Y-m-d', time()));
		$this->setTime(date('H:i:s', time()));
	}

	/**
	 * JSON Response
	 *
	 * @param $codeHttp - Code de statut
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function make($content, $error,  $codeHttp = 200, $url = '')
	{
		$this->setResponse($content);
		$this->setError($error);
		$this->setUrl($url);

		return response()->json(
			[
				'url' => $this->getUrl(),
				'date' => $this->getDate(),
				'time' => $this->getTime(),
				'statut' => $codeHttp,
				'response' => $this->getResponse(),
				'error' => $this->getError(),
			], $codeHttp);
	}

	//==== Getter ====

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		if( ! empty($url))
			$this->url = $url;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function setTime($time)
	{
		$this->time = $time;
	}


	//==== Setter ====

	public function getResponse()
	{
		return $this->response;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}

	public function getError()
	{
		return $this->error;
	}

	public function setError($error)
	{
		$this->error = $error;
	}

	public function getstatut()
	{
		return $this->statut;
	}

	public function setstatut($statut)
	{
		$this->statut = $statut;
	}

}
