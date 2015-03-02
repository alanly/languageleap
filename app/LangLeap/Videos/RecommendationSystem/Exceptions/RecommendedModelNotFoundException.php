<?php namespace LangLeap\Videos\RecommendationSystem\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class RecommendedModelNotFoundException extends ModelNotFoundException {

	private $key;


	/**
	 * Set the affected primary key.
	 * @param  mixed  $key The primary key of the affected model
	 * @return $this
	 */
	public function setKey($key)
	{
		$this->key = $key;

		return $this;
	}


	/**
	 * Get the affected primary key.
	 * @return mixed The primary key of the affected model
	 */
	public function getKey()
	{
		return $this->key;
	}
	
}
