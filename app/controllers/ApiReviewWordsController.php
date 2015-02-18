<?php

use LangLeap\Words\WordBank;

/**
 * @author Kwok-Chak Wan <martinwan1992@hotmail.com>
 */
class ApiReviewWordsController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	public function index()
	{
		$words = WordBank::where('user_id', '=', Auth::user()->id)->get();
		
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