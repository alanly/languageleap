<?php

use LangLeap\Words\WordBank;

class ReviewWordsController extends \BaseController {

	public function index()
	{
		$words = WordBank::where('user_id', '=', string)->get();
				
		if(!$words)
		{
			return $this->apiResponse('error', 'An error has occurred.', 400);
		}
		
		$decreasingWords = rsort($words);
		
		return $this->apiResponse(
			'success', $decreasingWords->toResponseArray()
		);
	}
}