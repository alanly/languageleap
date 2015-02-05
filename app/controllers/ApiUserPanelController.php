<?php
use LangLeap\Videos\Show;
use LangLeap\Core\Language;

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
	
		$data = ['fname' => $user->first_name, 'lname' => $user->last_name, 'lang' => $user->language_id, 'email' => $user->email];

		$langs = Language::all();

		foreach($langs as $lang)
		{
			$data[$lang->code] = ['language' => $lang->description];
		}

		return View::make('account.info')->with('data', $data);
	}
}
