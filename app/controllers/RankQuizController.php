<?php

use LangLeap\Accounts\User;
use LangLeap\Levels\Level;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;

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
			return View::make('rank.tutorialquiz')
					/*->with('q1', (Question::find(1)->question))
					->with('q2', (Question::find(2)->question))
					->with('q3', (Question::find(3)->question))
					->with('q4', (Question::find(4)->question))
					
					->with('a1', (Answer::find(1)->answer))
					->with('a2', (Answer::find(2)->answer))
					->with('a3', (Answer::find(3)->answer))
					->with('a4', (Answer::find(4)->answer))
					
					->with('a5', (Answer::find(5)->answer))
					->with('a6', (Answer::find(6)->answer))
					->with('a7', (Answer::find(7)->answer))
					->with('a8', (Answer::find(8)->answer))
					
					->with('a9', (Answer::find(9)->answer))
					->with('a10', (Answer::find(10)->answer))
					->with('a11', (Answer::find(11)->answer))
					->with('a12', (Answer::find(12)->answer))
					
					->with('a13', (Answer::find(13)->answer))
					->with('a14', (Answer::find(14)->answer))
					->with('a15', (Answer::find(15)->answer))
					->with('a16', (Answer::find(16)->answer))
						
					->with('a17', (Answer::find(17)->answer))
					->with('a18', (Answer::find(18)->answer))
					->with('a19', (Answer::find(19)->answer))
					->with('a20', (Answer::find(20)->answer))*/;
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
		// Compares answers and ranks the user
		$userScore = 0;
		
		$actualAnswer1 = Answer::find(Question::find($q1->id)->answer_id)->answer;
		$actualAnswer2 = Answer::find(Question::find($q2->id)->answer_id)->answer;
		$actualAnswer3 = Answer::find(Question::find($q3->id)->answer_id)->answer;
		$actualAnswer4 = Answer::find(Question::find($q4->id)->answer_id)->answer;
		$actualAnswer5 = Answer::find(Question::find($q5->id)->answer_id)->answer;

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
	}
	
	// Makes sure the user answered every question
	public function checkAnsweredAll()
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

	private function getUser()
	{
		return Auth::User();
	}
}
	