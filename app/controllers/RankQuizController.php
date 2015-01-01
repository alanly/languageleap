<?php

use LangLeap\Accounts\User;
use LangLeap\Levels\Level;

class RankQuizController extends \BaseController 
{
	public function getIndex()
	{
		$user = $this->getUser();
		if(!$user)
		{
			return Response::make("Must be logged in to access this page.", 404);
		}

		if($user->level_id == 0)
		{
			return View::make('rank.tutorialquiz');
		}
		else
		{
			return Redirect::to('/')
					->with('action.failed', true)
					->with('action.message', 'You have already taken the tutorial quiz!');
		}
	}

	public function rankUser()
	{
		//Get Answers here and rank the user based on score.
		//Make sure all the questions are answered.
		$userScore = 0;
		$actual_answer = Input::get("answer_id");
		$user_answer = Input::get("selected_id");
		
		if($userScore <= 1)
		{
			$user->level_id = 1;
		}
		else if($userScore > 1 && $userScore <= 3)
		{
			$user->level_id = 2;
		}
		else if($userScore > 3 && <= 5)
		{
			$user->level_id = 3;
		}
	}

	private function getUser()
	{
		return Auth::User();
	}
}
	