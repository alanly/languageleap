<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Attribute is a specific video attribute from the preference model's collection
 * of attributes. Each attribute contains a set of residents of that attribute.
 * For example, and "actors" attribute would contain a set of actors and the
 * respective counter for each actor.
 * @author Alan Ly <hello@alan.ly>
 */
class Attribute {

	private $residents = [];


	/**
	 * Either adds a new resident to the attribute or increments an existing one.
	 * In either case, the function returns the new count for that resident.
	 * @param  string  $name  The name of the resident
	 * @return int            The count of the addressed resident
	 */
	public function add($name)
	{
		// Initialize the resident if it is new.
		if (! isset($this->residents[$name]))
		{
			$this->residents[$name] = 0;
		}

		return ++$this->residents[$name];
	}


	/**
	 * Returns the current count of the requested attribute resident. The value
	 * represents the number of videos the user has seen, in which the attribute
	 * resident occurs.
	 * @param  string  $name  The name of the resident
	 * @return int            The count of the requested resident
	 */
	public function count($name)
	{
		// If the resident does not exist, then return zero because that resident
		// has occured zero times in the viewing history.
		if (! isset($this->residents[$name])) return 0;

		return $this->residents[$name];
	}


	/**
	 * Create a new Attribute instance.
	 * @return Attribute The new attribute instance
	 */
	public function newInstance()
	{
		return new self();
	}

}
