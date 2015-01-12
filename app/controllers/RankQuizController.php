<?php

use LangLeap\Levels\Level;
use LangLeap\Rank\Quiz as RankQuiz;
use LangLeap\Rank\QuizCreationListener as RankQuizCreationListener;
use LangLeap\Rank\RankingListener;

/**
 * @author KC Wan
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 */
class RankQuizController
	extends \BaseController
	implements RankingListener, RankQuizCreationListener {

	/**
	 * @var LangLeap\Levels\Level
	 */
	protected $levels;


	public function __construct(Level $levels)
	{
		// Enable filters for this controller.
		$this->beforeFilter('auth');
		$this->beforeFilter('ajax', ['except' => 'getIndex']);
		$this->beforeFilter('csrf', ['on' => 'post|put']);
		$this->beforeFilter('@filterUnrankedUsers');

		// Assign the injected dependencies.
		$this->levels = $levels;
	}


	public function getIndex()
	{
		return View::make('rank.tutorialquiz');
	}


	public function getQuiz()
	{
		// Get an instance of our quiz creator.
		$quizCreator = App::make('LangLeap\Rank\QuizCreator');

		// Create the quiz.
		$quiz = $quizCreator->createQuiz($this);

		// Generate the response
		return $this->apiResponse('success', $quiz);
	}


	public function postIndex()
	{
		$questions = Input::get('questions');

		// There should be 5 questions.
		if (! $questions || (count($questions) < 5))
		{
			return $this->apiResponse('error', 'Missing or incomplete questions object in request.', 400);
		}

		$userRanker = App::make('LangLeap\Rank\UserRanker');

		return $userRanker->rank($this, Auth::user(), $questions);
	}


	public function filterUnrankedUsers($route, $request)
	{
		$user = Auth::user();
		$unrankedLevel = $this->levels->where('code', 'ur')->first();

		// Return to home if the user has already been ranked.
		if ($user->level_id !== $unrankedLevel->id) return Redirect::to('/');
	}


	public function userRanked($user)
	{
		if (! $user)
		{
			return $this->apiResponse('error', 'Error when updating user.', 500);
		}

		// Generate a response containing the user and the redirection URL.
		return $this->apiResponse(
			'success', [ 'user' => $user, 'redirect' => URL::to('/') ]
		);
	}


	public function quizCreated(RankQuiz $quiz)
	{
		// We'll simply return the quiz instance.
		return $quiz;
	}

}
