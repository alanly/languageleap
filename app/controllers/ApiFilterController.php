<?php

use LangLeap\Videos\Movie;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Show;

/**
 * @author Michael Lavoie
 */
class ApiFilterController extends \BaseController {

	/**
	* The maximum number of filtered results that
	* can be retrieved in one shot.
	* @var int 
	*/
	private $maxTake;

	public function __construct()
	{
		$this->maxTake = Config::get('filtering.max_take');
	}

	/**
	* Retrieves a collection of metadata for filtered content.
	*/
	public function index()
	{
		$take = Input::get('take');
		$skip = Input::get('skip');
		$type = Input::get('type');

		if (! $type || ! $this->isTakeValid($take) || ! $this->isSkipValid($skip))
		{
			return $this->apiResponse(
				'error',
				'Invalid parameters',
				400
			);
		}

		if ($type == 'movie')
			$res = Movie::filterBy(Input::get(), $take, $skip);
		else if ($type == 'commercial')
			$res = Commercial::filterBy(Input::get(), $take, $skip);
		else
			$res = Show::filterBy(Input::get(), $take, $skip);

		return $this->apiResponse(
			'success',
			$res->map(function($r)
			{
				return ($r instanceof LangLeap\Videos\Media) ? $r->toResponseArray() : $r;
			}),
			200
		);
	}

	private function isTakeValid($take)
	{
		if ($take && is_numeric($take)
			&& $take > 0 && $take <= $this->maxTake)
			return true;

		return false;
	}

	private function isSkipValid($skip)
	{
		if (is_numeric($skip) || is_int($skip))
			return true;

		return false;
	}

}
