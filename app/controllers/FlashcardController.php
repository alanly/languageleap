<?php

use LangLeap\Words\Definition;

class FlashcardController extends \BaseController {

	public function postIndex()
	{
		$words = Input::get("definitions");
		$wordArray = array();
		foreach($words as $wordKey => $wordId)
		{
			$word = Definition::find($wordId);
			array_push($wordArray, $word->toArray());
		}

		return View::make('flashcard')->with('words', $wordArray);
	}

}
