<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Core\Collection;
use LangLeap\Videos\Video;
use LangLeap\Videos\RecommendationSystem\ScoredMedia;
use LangLeap\Videos\RecommendationSystem\ClassificationDrivers\ClassificationDriver;

/**
 * ScoreGenerator is responsible for retrieving a collection of media instances
 * and scoring them against the user, thus determining the suitability of each
 * video based on the user's profile.
 * @author Alan Ly <hello@alan.ly>
 */
class ScoreGenerator {

	/**
	 * The classification driver instance that should be used to determine the
	 * recommendations.
	 * @var ClassificationDriver
	 */
	private $driver;

	/**
	 * The videos repository instance.
	 * @var Video
	 */
	private $videos;


	/**
	 * Constructs a new instance.
	 * @param ClassificationDriver $driver The driver that should be used to classify videos
	 */
	public function __construct(ClassificationDriver $driver, Video $videos)
	{
		$this->driver = $driver;
		$this->videos = $videos;
	}


	/**
	 * Scores media for the given user. Returned is a collection of `ScoredMedia`
	 * instances, each of which contain the media and its associated score.
	 * @param  Historable $user The historable user instance
	 * @return Collection
	 */
	public function score(Historable $user)
	{
		// Get all the media instances in the system.
		$media = $this->assembleMediaCollection();

		// Iterate through the media collection and get the score for each.
		$scores = $media->map(function($m) use ($user)
		{
			return $this->scoreMediaForUser($user, $m);
		});

		return $scores;
	}


	/**
	 * Retrieves a set of all the media in the system.
	 * @return Collection
	 */
	private function assembleMediaCollection()
	{
		// Retrieve all the videos in the database.
		$videos = $this->videos->with('viewable')->all();

		// In order to maintain a set of the associated media, we will create a
		// hashmap via a dictionary, wherein the keys are hashvalues unique to each
		// media instance.
		$mediaSet = [];

		foreach ($videos as $v)
		{
			// Get the media instance from the video.
			$media = $v->viewable;

			// Skip if it's not classifiable.
			if (! ($media instanceof Classifiable)) continue;

			// Get the unique hash.
			$mediaHash = $media->getHash();

			// Add the instance to the set if it's not already added.
			if (! isset($mediaSet[$mediaHash]))
			{
				$mediaSet[$mediaHash] = $media;
			}
		}

		return new Collection(array_values($mediaSet));
	}


	/**
	 * Given a historable user instance and a classifiable media instance, scores
	 * the media, and returns the ScoredMedia instance.
	 * @param  Historable   $user  The historable user
	 * @param  Classifiable $media The classifiable media
	 * @return ScoredMedia
	 */
	private function scoreMediaForUser(Historable $user, Classifiable $media)
	{
		$score = $this->driver->classify($user, $media);

		return new ScoredMedia($media, $score);
	}
	
}
