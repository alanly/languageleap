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
	
}
