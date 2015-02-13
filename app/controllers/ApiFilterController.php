<?php

use LangLeap\Videos\FilterSystem\Filtrator;
use LangLeap\Videos\Movie;

/**
 * @author Michael Lavoie
 */
class ApiFilterController extends \BaseController {

	private $filtrator;

	public function __construct(Filtrator $filtrator)
	{
		$this->filtrator = $filtrator;
	}

	public function index()
	{
		$type = Input::get('type');
		$take = Input::get('take');
		$skip = Input::get('skip');

		if (! $type) return [];

		if ($type == 'movie')
			$filterable = new Movie();
		else if ($type == 'commercial')
			$filterable = new Commercial();
		else // Assume the type is 'Show'
			$filterable = new Show();

		if ($skip)
			$results = $this->filtrator->filterBy($filterable, Input::get(), $take, $skip);
		else
			$results = $this->filtrator->filterBy($filterable, Input::get(), $take);

		return $results;
	}

}
