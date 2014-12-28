<?php

use LangLeap\Accounts\User;
use LangLeap\Levels\Level;

class RankController extends \BaseController 
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
			return View::make('rank.tutorialvideo');
		}
		else
		{
			return Redirect::to('/')
					->with('action.failed', true)
					->with('action.message', 'You have already taken the tutorial quiz!');
		}
	}

	private function getUser()
	{
		return Auth::User();
	}
}
	