<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Videos\RecommendationSystem\Repositories\RecommendationRepository;

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
	 * @param ScoreGenerator $generator The generator instance to use
	 */
	public function __construct(
		ScoreGenerator $generator, RecommendationRepository $recommendations)
	{
		$this->generator = $generator;
		$this->recommendations = $recommendations;
	}


	/**
	 * Given a historable user, will freshly generate recommendations for the user.
	 * @param  Historable $user The user to generate recommendations for
	 * @return Collection       The recommendations, sorted in descending order of score
	 */
	public function generate(Historable $user)
	{
		// @TODO Get a collection of Recommendation instances.
		
		// @TODO Clear the repository for the user.
		
		// @TODO Save those Recommendations into the repository.
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
		// @TODO Alias the repository getTop method.
	}
	
}
