<?php

use LangLeap\Accounts\User;
use LangLeap\Levels\Level;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;

class SkipRankController extends \BaseController 
{
	public function getIndex()
	{
		$user = Auth::user();
		if(!$user)
		{
			return Response::make("Must be logged in to access this page.", 404);
		}

		if($user->level_id != 1)
		{
			return Response::make("You have already been ranked.", 404);
		}
		else
		{
			$user->level_id = 2;
			$user->save();
			return Redirect::to('/level');
		}
	}
}
	