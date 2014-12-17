<?php

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class LanguageController extends BaseController {

	public function setLanguage($lang)
	{
		Session::put('lang', $lang);
		
		return Redirect::to(URL::previous());
	}
}