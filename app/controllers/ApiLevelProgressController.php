<?php

use LangLeap\Accounts\User;

/**
 * @author Kwok-Chak Wan <martinwan1992@hotmail.com>
 */
class ApiLevelProgressController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth');
	}
	
	public function postIndex()
	{
		$user = Auth::user();
		
		$quizScore = Input::get('score');
		$levelUp = false;
		
		$exponentFactor = 2.5;
		$levelFactor = 1.5;
		$scoreMultiplier = 0.1;
		$levelIncrease = 1;
		
		$currentLevel = $user->level_id;
		$userTotalPoints = $user->total_points;
		
		$requiredPoints = ceil((pow($currentLevel, $exponentFactor)) * $levelFactor);
		
		$pointsEarned = ceil($quizScore * $scoreMultiplier * $levelFactor * $currentLevel);
		
		$userTotalPoints += $pointsEarned;
		
		if($userTotalPoints >= $requiredPoints)
		{
			$currentLevel += $levelIncrease;
			$levelUp = true;
		}
		
		return $this->apiResponse(
			'success',
			[
				'level_id' => $currentLevel,
				$levelUp
			], 
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