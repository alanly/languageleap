<?php namespace LangLeap\Rank;

use LangLeap\Core\Collection;

/**
 * A ranking quiz representation structure.
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz {

	public    $questions;
	protected $collection;


	public function __construct(Collection $collection)
	{
		$this->collection = $collection;

		$this->questions = new Collection;
	}
	
}
