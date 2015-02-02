<?php namespace LangLeap\Videos\RecommendationSystem;

use Illuminate\Database\Eloquent\Collection;
use LangLeap\Videos\RecommendationSystem\Repositories\RecommendationRepository;

/**
 * Recommendatore is the recommendation system helper class that can be used by
 * clients to either generate (and store) recommendations or retrieve stored
 * recommendations from the datastore. It is suggested that users implement this
 * class rather than attempting to work with the individual underlying classes
 * directly.
 * @author Alan Ly <hello@alan.ly>
 */
class Recommendatore {

	/**
	 * The ScoreGenerator instance.
	 * @var ScoreGenerator
	 */
	private $generator;

	/**
	 * The repository store for recommendation instances.
	 * @var RecommendationRepository
	 */
	private $recommendations;


	/**
	 * Constructs a new instance.
	 * @param ScoreGenerator           $generator       The generator instance to use
	 * @param RecommendationRepository $recommendations The repository for recommendation instances
	 */
	public function __construct(
		ScoreGenerator $generator, RecommendationRepository $recommendations)
	{
		$this->generator = $generator;
		$this->recommendations = $recommendations;
	}


	/**
	 * Given a historable user, will freshly generate recommendations for the user.
	 * This is an intensive operation and should not be called each time a
	 * recommendation is needed. Rather, it should be called at intervals in order
	 * to create a fresh data set of recommendations to be used.
	 * @param  Historable $user The user to generate recommendations for
	 * @return Collection       The recommendations, sorted in descending order of score
	 */
	public function generate(Historable $user)
	{
		// Generate and get a collection of Recommendation instances.
		$scored = $this->generator->score($user);
		
		// Replace the existing dataset in the repository with the fresh data.
		$this->replaceRecommendations($user, $scored);
		
		// Return the collection of recommendations.
		return $scored;
	}


	/**
	 * Given a historable user, will retrieve a number of stored recommendations
	 * in the specified ordering. Note that the recommendations set is ordered
	 * by score via specified parameter before the specified amount is taken from
	 * that ordered set. Therefore, the method will either return a number of most
	 * recommended items or a number of least recommended items. The ordering
	 * parameter defaults to descending (i.e. highly to lowly recommended)
	 * @param  Historable $user  The user to retrieve recommendations for
	 * @param  int        $take  The number of recommendations to retrieve
	 * @param  bool       $desc  Order the recommendations set in descending order (default)
	 * @return Collection        The recommendations in sorted order of score
	 */
	public function fetch(Historable $user, $take, $desc = true)
	{
		// Alias the repository getTop method.
		return $this->recommendations->getTop($user, $take, $desc);
	}


	/**
	 * Given a user instance and a collection of recommendations, this method will
	 * replace all existing recommendations in the repository for the user with
	 * those given by the collection.
	 * @param  Historable $user   The owner of the recommendations
	 * @param  Collection $scored The collection of recommendations to store
	 * @return bool               The success state of the operation
	 */
	private function replaceRecommendations(Historable $user, Collection $scored)
	{
		// Empty the repository if it's populated.
		if ($this->recommendations->count($user) > 0)
		{
			$this->recommendations->removeAll($user);
		}

		return $this->recommendations->multiAdd($user, $scored);
	}
	
}
