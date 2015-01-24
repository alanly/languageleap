<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Core\Collection;

class Utilities {

	/**
	 * Given a traversable collection of viewing history, this method will return
	 * a collection of Media instances which are classifiable.
	 * @param  Collection  $history  The user's viewing history
	 * @return Collection            The classifiable media instances
	 */
	public function getClassifiableMediaFromHistory(Collection $history)
	{
		// Map over the history and create a collection of classifiable media instances.
		$media = $history->map(function($h)
		{
			$m = $h->video->viewable;

			if ($m instanceof Classifiable) return $m;
		});

		return $media;
	}


	/**
	 * Given either an instance or collection of Classifiable media, this method
	 * will return a collection consisting of the value given by the
	 * `getClassificationAttributes()` method from each item.
	 * @param  mixed  $media  The instance or collection of Classifiable media
	 * @return Collection
	 */
	public function getClassificationAttributesFromMedia($media)
	{
		// If the parameter is a single instance, then just return the attributes from that instance.
		if ($media instanceof Classifiable) 
		{
			return new Collection([$media->getClassificationAttributes()]);
		}

		// If the parameter is a Collection instance, then use the map function to create
		// our collection.
		if ($media instanceof Collection)
		{
			$attributes = $media->map(function($m)
			{
				return $m->getClassificationAttributes();
			});

			return $attributes;
		}

		// If it's another iterable collection, then fall back to a foreach.
		$attributes = new Collection;

		foreach ($media as $m)
		{
			$attributes->push($m->getClassificationAttributes());
		}

		return $attributes;
	}


	/**
	 * Given a model instance and a collection of attributes, this method will
	 * populate the model instance with the attributes.
	 * @param  Model      $model      The model to update
	 * @param  Collection $attributes The collection of attributes to add to the model
	 * @return Model
	 */
	public function populateModelFromAttributes(Model $model, Collection $attributes)
	{
		// Iterate through each "attribute" set, which is actually a dictionary.
		$attributes->each(function($a) use ($model)
		{
			// Iterate through the individual attributes in each set
			foreach($a as $k => $v)
			{
				// Update the model.
				$this->addAttributeToModel($model, $k, $v);
			}
		});

		// Return the populated model instance.
		return $model;
	}


	/**
	 * Given a model, the name of an attribute, and the resident(s) for that
	 * attribute, this method will add the attribute to the model. The return value
	 * is the attribute instance that is being updated.
	 * @param  Model  $model The model the attribute belongs to
	 * @param  string $name  The name of the attribute
	 * @param  mixed  $value The value or array of values
	 * @return Attribute     The attribute instance
	 */
	private function addAttributeToModel(Model $model, $name, $value)
	{
		// Get the attribute instance from the model.
		$attribute = $model->{$name};

		// If the value isn't array, convert it to one so that we can DRY-ly work
		// with it.
		if (! is_array($value)) $value = [$value];

		// Add each resident to the attribute.
		foreach ($value as $v)
		{
			$attribute->add($v);
		}

		return $attribute;
	}
	
}
