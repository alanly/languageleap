<?php

use LangLeap\Words\Word;

class FlashcardController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/*public function getIndex()
	{
		return View::make('flashcard');
	}*/


	public function postIndex()
	{
		$words = Input::get();
		$wordArray = array();

		foreach($words as $wordKey => $wordId)
		{
			$word = Word::find($wordId);
			array_push($wordArray, $word->toArray());
		}

		return View::make('flashcard')->with('words', $wordArray);
	}
}
