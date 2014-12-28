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
			return $this->apiResponse(
				'error',
				"Must be logged in to access this page.",
				404
			);
		}

		if($user->level_id == null)
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
	}

	private function getUser()
	{
		return Auth::User();
	}
}
	