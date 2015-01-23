<?php namspace LangLeap\Videos\RecommendationSystem;

/**
 * Model represents the user's viewing preferences. It maintains a count of
 * commonly occuring attributes from videos that the user has seen.
 * @author Alan Ly <hello@alan.ly>
 */
class Model {

	/**
	 * @var Attribute
	 */
	private $attribute;

	private $attributes = [];


	public function __construct(Attribute $attribute)
	{
		$this->attribute = $attribute;
	}


	/**
	 * Magic method for retrieving a particular attribute.
	 * @param  string  $name  The name of the attribute
	 * @return Attribute
	 */
	public function __get($name)
	{
		if (! isset($this->attributes[$name]))
		{
			$this->attributes[$name] = $this->attribute->newInstance();
		}

		return $this->attributes[$name];
	}

}
