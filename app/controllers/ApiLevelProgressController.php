<?php

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
		
		$quizScore = 0.8; //will be changed to percentage, currently 80% on quiz
		
		$exponentFactor = 2.5;
		$levelFactor = 1.5;
		$scoreMultiplier = 10;
		const levelUp = 1;
		
		$currentLevel = $user->level_id->get();
		$userTotalPoints = $user->total_points->get();
		
		$requiredPoints = ceil((pow($currentLevel, $exponentFactor)) * $levelFactor);
		
		$pointsEarned = ceil($quizScore * $scoreMultiplier * $levelFactor * $currentLevel);
		
		$userTotalPoints += $pointsEarned;
		
		if($userTotalPoints >= $requiredPoints)
		{
			$currentLevel += $levelUp;
		}
		
		return $this->apiResponse(
			'success',
			['level_id' => $currentLevel], 
			200
		);
	}
	
	public function getIndex()
	{
		$user = Auth::user();
		
		$currentLevel = $user->level_id->get();
		
		return $this->apiResponse(
			'success',
			['level_id' => $currentLevel],
			200
		);
	}
}