<?php
use LangLeap\Videos\Show;
use LangLeap\Core\Language;

class ApiUserPanelController extends \BaseController {

	/**
	 * Show the flashcards of a user
	 */
	public function showSelectedWords()
	{
		return View::make('account.selectedWords');
	}
	
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
	
		$data = ['fname' => $user->first_name, 'lname' => $user->last_name, 'lang' => $user->language_id, 'email' => $user->email, 'password' => $user->password];

		$langs = Language::all();
		
		return View::make('account.info')->with('data', $data)->with('langs', $langs);
	}
	
	public function showQuizHistory()
	{
		return View::make('account.quizHistory');
	}
}
