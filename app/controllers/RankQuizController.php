<?php

use LangLeap\Accounts\User;
use LangLeap\Levels\Level;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;

class RankQuizController extends \BaseController 
{
	public function getIndex()
	{
		$user = Auth::user();
		if(!$user)
		{
			return Response::make("Must be logged in to access this page.", 403);
		}

		if($user->level_id == Level::where('code','=','ur')->first()->id)
		{
			return View::make('rank.tutorialquiz');
		}
		else
		{
			return Redirect::to('/');
		}
	}

	public function rankUser()
	{
		// Compares answers and ranks the user
		$userScore = 0;
		
		$actualAnswer1 = Answer::find(Question::find(Input::get('q1'))->answer_id)->answer;
		$actualAnswer2 = Answer::find(Question::find(Input::get('q2'))->answer_id)->answer;
		$actualAnswer3 = Answer::find(Question::find(Input::get('q3'))->answer_id)->answer;
		$actualAnswer4 = Answer::find(Question::find(Input::get('q4'))->answer_id)->answer;
		$actualAnswer5 = Answer::find(Question::find(Input::get('q5'))->answer_id)->answer;

		if(Input::get('a1') == $actualAnswer1)
		{
			$userScore++;
		}
		if(Input::get('a2') == $actualAnswer2)
		{
			$userScore++;
		}
		if(Input::get('a3') == $actualAnswer3)
		{
			$userScore++;
		}
		if(Input::get('a4') == $actualAnswer4)
		{
			$userScore++;
		}
		if(Input::get('a5') == $actualAnswer5)
		{
			$userScore++;
		}
		
		$user = Auth::user();
		if($userScore <= 1)
		{
			$user->level_id = 1;
		}
		if($userScore > 2 && $userScore <= 3)
		{
			$user->level_id = 2;
		}
		if($userScore > 3 && $userScore <= 5)
		{
			$user->level_id = 3;
		}
		$user->save();
		
		return Redirect::to('/');
	}
	
	// Makes sure the user answered every question
	public function postAnswers()
	{
		$answeredAll = false;
		
		$a1 = Input::get('a1');
		$a2 = Input::get('a2');
		$a3 = Input::get('a3');
		$a4 = Input::get('a4');
		$a5 = Input::get('a5');
		
		if($a1 && $a2 && $a3 && $a4 && $a5)
		{
			$answeredAll = true;
			return $this->rankUser();
		}
		else
		{
			return Redirect::to('rank.tutorialquiz')
				->with('action.failed', true)
				->with('action.message', 'You need to answer all the questions before proceeding!');
		}
	}
}
	