<?php
use LangLeap\Videos\Show;

class ApiUserLevelController extends \BaseController {
	
	/**
	 * Show the level for the given user.
	 */
	public function showLevel()
	{
		$user = Auth::user();
	
		return View::make('account.level')->with('level', $user->level()->first());
	}
}
