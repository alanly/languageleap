<?php

use LangLeap\Accounts\User
use LangLeap\Levels\Level

class FirstTimeRankController extends \BaseController {
	
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public  function getTutorialVideo()
	{
		return View::make('rank.tutorialvideo');
	}
	
	public function checkUserLevel($user)
	{
		if($user->level_id == null)
		{
			return Redirect::action('FirstTimeRankController@getTutorialVideo');
		}
		else
		{
			return Redirect::to('/')
					->with('action.failed', true)
					->with('action.message', 'You have already taken the tutorial quiz!');
		}
	}
}
	