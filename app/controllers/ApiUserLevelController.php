<?php
use LangLeap\Videos\Show;

class ApiShowController extends \BaseController {

	    /**
     * Show the profile for the given user.
     */
    public function showLevel($id)
    {
        $user = User::find($id);

        return View::make('account.level', 'user' => $language_id);
    }
}
