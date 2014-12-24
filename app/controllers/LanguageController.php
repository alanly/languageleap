<?php

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class LanguageController extends BaseController {

	/*
	 *	This function will set the language.
	 */
	public function setLanguage($lang)
	{
		Session::put('lang', $lang);
		
		return Redirect::to(URL::previous());
	}
}