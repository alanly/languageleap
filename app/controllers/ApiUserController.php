<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class ApiUserController extends \BaseController {

	protected $users;

	public function __construct(User $user)
	{
		$this->userss = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  int  $userId
	 * @return JsonResponse
	 */
	public function show($id)
	{
	
	}

}
