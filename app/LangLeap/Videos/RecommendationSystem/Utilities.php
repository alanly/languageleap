<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Core\Collection;
use Traversable;

class Utilities {

	/**
	 * Given a traversable collection of viewing history, this method will return
	 * a collection of Media instances which are classifiable.
	 * @param  Traversable  $history  The user's viewing history
	 * @return Collection             The classifiable media instances
	 */
	public function getClassifiableMediaFromHistory(Traversable $history)
	{
		$media = new Collection;

		// Add each media to the collection if it's classifiable.
		foreach ($history as $h)
		{
			// Get the media instance from the history.
			$m = $h->video->viewable;

			// Push it onto the collection if it's classifiable.
			if ($m instanceof Classifiable) $media->push($m);
		}

		return $media;
	}


	/**
	 * Given either an instance or collection of Classifiable media, this method
	 * will return a collection consisting of the value given by the
	 * `getClassificationAttributes()` method from each item.
	 * @param  mixed  $media  The instance or collection of Classifiable media
	 * @return Traversable
	 */
	public function getClassificationAttributesFromMedia($media)
	{
		$attributes = new Collection;

		// If the parameter is a single instance, then just return the attributes from that instance.
		if ($media instanceof Classifiable) 
		{
			$attributes->push($media->getClassificationAttributes());
			return $attributes;
		}

		foreach ($media as $m)
		{
			$attributes->push($m->getClassificationAttributes());
		}

		return $attributes;
	}
	
}
