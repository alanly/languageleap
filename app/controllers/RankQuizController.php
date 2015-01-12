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
		$this->beforeFilter('@filterRankedUsers');
		$this->beforeFilter('csrf', ['on' => 'post|put']);

		// Assign the injected dependencies.
		$this->levels = $levels;
	}


	public function getIndex()
	{
		return View::make('rank.tutorialquiz');
	}


	public function postIndex()
	{
		// The request must be via AJAX, in JSON form.
		if (! Request::ajax() && ! Request::isJson())
		{
			return $this->apiResponse('error', 'Invalid request method.', 405);
		}

		$questions = Input::get('questions');

		// There should be 5 questions.
		if (! $questions || (count($questions) < 5))
		{
			return $this->apiResponse('error', 'Missing or incomplete questions object in request.', 400);
		}

		$userRanker = App::make('LangLeap\Rank\UserRanker');

		return $userRanker->rank($this, Auth::user(), $questions);
	}


	public function filterRankedUsers($route, $request)
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
		// @TODO handle response for created quiz.
	}

}
