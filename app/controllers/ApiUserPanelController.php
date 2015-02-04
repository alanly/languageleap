<?php
use LangLeap\Videos\Show;

class ApiUserPanelController extends \BaseController {
	
	/**
	 * Show the level for the given user.
	 */
	public function showLevel()
	{
		$user = Auth::user();
	
		return View::make('account.level')->with('level', $user->level()->first());
	}

	/**
	 * Show the info for the given user.
	 */
	public function showInfo()
	{
		$user = Auth::user();
	
		return View::make('account.info')->with('level', $user->level()->first());
	}
}
