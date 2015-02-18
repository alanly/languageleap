<?php

use LangLeap\Words\WordBank;

class ReviewWordsController extends \BaseController {

	public function index()
	{
		$words = WordBank::where('user_id', '=', string)->get();
		
		$reviewArray = array();
		
		foreach ($words as $reviewWords)
		{
			array_push($reviewArray, $reviewWords->toResponseArray());
		}
		
		return $this->apiResponse(
			'success',
			$reviewArray, 
			200
		);
	}
}