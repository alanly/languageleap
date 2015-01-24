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
	
}
