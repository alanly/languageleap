<?php namespace LangLeap\Videos\FilterSystem;

use LangLeap\Videos\FilterSystem\Filterable;
use Config;

/**
 * Filtrator is a helper class that is used to
 * match Filterable objects to query data.
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class Filtrator {

	private $maxTake;

	public function __construct()
	{
		$this->maxTake = Config::get('filtersystem.max_take');
	}

	/**
	 * Given a Filterable type and an array of input data, will match Filterable objects
	 * and return the specified range of results.
	 * @param  Filterable  $type    The type to filter through
	 * @param  array       $input   A dictionary of input to match
	 * @param  int         $take    The number of matches to retrieve
	 * @param  int         $skip    The starting index of where to start retrieving
	 * @return Collection           The filtered data
	 */
	public function filterBy(Filterable $type, $input, $take, $skip = 0)
	{
		if (! $type || ! $input ||
			! $this->isTakeValid($take) || ! $this->isSkipValid($skip))
			return [];

		$attributes = $type->getFilterableAttributes();
		$query = $type->query();

		foreach ($attributes as $a)
		{
			if (! $input[$a]) continue;

			$query->where($a, '=', $input[$a]);
		}

		return $query->take($take)->skip($skip)->get();
	}

	public function isTakeValid($take)
	{
		if ($take && is_numeric($take)
			&& $take > 0 && $take <= $this->maxTake)
			return true;

		return false;
	}

	public function isSkipValid($skip)
	{
		if (is_numeric($skip) || is_int($skip))
			return true;

		return false;
	}

}
