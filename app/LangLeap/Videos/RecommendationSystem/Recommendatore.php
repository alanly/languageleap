<?php namespace LangLeap\Videos\RecommendationSystem;

class Recommendatore {

	/**
	 * The ScoreGenerator instance.
	 * @var ScoreGenerator
	 */
	private $generator;


	/**
	 * Constructs a new instance.
	 * @param ScoreGenerator $generator The generator instance to use
	 */
	public function __construct(ScoreGenerator $generator)
	{
		$this->generator = $generator;
	}


	/**
	 * Given a historable user, will freshly generate recommendations for the user.
	 * @param  Historable $user The user to generate recommendations for
	 * @return Collection       The recommendations, sorted in descending order of score
	 */
	public function generate(Historable $user)
	{

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
	 * @param  string     $order The ordering of the recommendations set (either 'asc' or 'desc', default is 'desc')
	 * @return Collection        The recommendations in sorted order of score
	 */
	public function fetch(Historable $user, $take, $order = 'desc')
	{

	}
	
}
