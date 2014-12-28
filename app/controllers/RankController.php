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
			return Response::make("Must be logged in to access this page.", 404);
		}

		if($user->level_id == 0)
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
	