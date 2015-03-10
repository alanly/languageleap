<?php

use LangLeap\Accounts\User;

/**
 * @author Kwok-Chak Wan <martinwan1992@hotmail.com>
 */
class ApiLevelProgressController extends \BaseController {

	const exponentFactor = 2.5;
	const levelFactor = 1.5;
	const scoreMultiplier = 0.1;
	const levelIncrease = 1;
	
	public function __construct()
	{
		$this->beforeFilter('auth');
	}
	
	public function postIndex()
	{
		$user = Auth::user();
		
		$message = "";
		
		$quizScore = Input::get('score');
		
		if($quizScore === null || $quizScore < 0)
		{
			$message = Lang::get('controllers.quiz.level_error');
			
			return $this->apiResponse(
				'error',
				['message' => $message],
				400
			);
		}
		
		$currentLevel = $user->level_id;
		$userTotalPoints = $user->total_points;
		
		//required = ceiling((userLevel^2.5) * 1.5)
		$requiredPoints = ceil((pow($currentLevel, ApiLevelProgressController::exponentFactor)) * ApiLevelProgressController::levelFactor);
		
		//earned = ceiling(quizScore * 0.1 * 1.5 * userLevel)
		$pointsEarned = ceil($quizScore * ApiLevelProgressController::scoreMultiplier * ApiLevelProgressController::levelFactor * $currentLevel);
		
		$userTotalPoints += $pointsEarned;

		if($userTotalPoints >= $requiredPoints)
		{
			$currentLevel += ApiLevelProgressController::levelIncrease;
			$user->level_id = $currentLevel;
			$message = Lang::get('controllers.quiz.level_up');
		}
		
		$user->total_points = $userTotalPoints;
		$user->save();
		
		return $this->apiResponse(
			'success',
			['message' => $message, 'level_id' => $currentLevel], 
			200
		);
	}
	
	public function getIndex()
	{
		$user = Auth::user();
		
		$currentLevel = $user->level_id;
		
		return $this->apiResponse(
			'success',
			['level_id' => $currentLevel],
			200
		);
	}
}