<?php

use LangLeap\Words\Word;

class FlashcardController extends BaseController {

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
