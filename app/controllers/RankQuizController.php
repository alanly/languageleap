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
		$this->beforeFilter('ajax', ['except' => ['getIndex', 'getVideo', 'getSkip']]);
		$this->beforeFilter('csrf', ['on' => 'post|put']);
		$this->beforeFilter('@filterUnrankedUsers');

		// Assign the injected dependencies.
		$this->levels = $levels;
	}


	public function getIndex()
	{
		return View::make('rank.quiz');
	}

	public function getVideo()
	{
		return View::make('rank.tutorialvideo');
	}

	/**
	 * Skips user ranking and redirects to user profile page.
	 */
	public function getSkip()
	{
		$user = Auth::user();
		
		// if not ranked
		if ($user->level_id == Level::where('code', '=', 'ur')->first()->id)
		{
			$user->level_id = Level::where('code', '=', 'be')->first()->id;
			$user->save();
			return Redirect::to('/');
		}
		else
		{
			return Response::make("You have already been ranked.", 400);
		}
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


	public function postQuiz()
	{
		$questions = Input::get('questions');

		// There should be questions.
		if (! $questions || (count($questions) < 1))
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

		// Generate a response containin the needed values.
		return $this->apiResponse(
			'success', [ 'user' => $user, 'level' => $user->level, 'redirect' => URL::to('/') ]
		);
	}


	public function quizCreated(RankQuiz $quiz)
	{
		// We'll simply return the quiz instance.
		return $quiz;
	}

}
