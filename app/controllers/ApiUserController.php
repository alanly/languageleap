<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiUserController extends \BaseController {

	protected $users;

	private $rules = [
		'username' => 'required|alpha_dash|max:20|unique:users',
		'email' => 'required|email|unique:users',
		'password' => 'required|min:6|max:20',
		'first_name' => 'required|max:40',
		'last_name' => 'required|max:40'
	];

	public function __construct(User $users)
	{
		$this->users = $users;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::check())
		{
			return $this->apiResponse(
				'error',
				"User is already logged in",
				401
			);
		}

		$validator = Validator::make(Input::get(), $this->rules);
		if ($validator->fails())
		{
			return $this->apiResponse(
				'error',
				$validator->messages(),
				400
			);
		}

		$user = new User;

		$user->fill(Input::get());

		if (! $user->save())
		{
			return $this->apiResponse(
				'error',
				$user->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$user->toArray(),
			201
		);	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  int  $userId
	 * @return JsonResponse
	 */
	public function show($userId)
	{
		if (! ($userId == Auth::user()->id))
		{
			return $this->apiResponse(
				'error',
				"User {Auth::id()} attempted to access user {$userId}.",
				401
			);
		}

		$user = User::find($userId);
		
		// This should ideally never happen because it would mean that
		// the currently authenticated user doesn't exist in the database anymore.
		if (! $user)
		{
			return $this->apiResponse(
				'error',
				"User {$userId} not found.",
				404
			);
		}
		
		return $this->apiResponse(
			'success',
			$user->toArray(),
			200
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $userId
	 * @return Response
	 */
	public function update($userId)
	{
		if (! ($userId == Auth::user()->id))
		{
			return $this->apiResponse(
				'error',
				"User {Auth::id()} attempted to modify user {$userId}.",
				401
			);
		}

		$updateRules = $this->rules;
		$updateRules['username'] .= ",$userId";
		$updateRules['email'] .= ",$userId";

		$validator = Validator::make(Input::get(), $updateRules);
		if ($validator->fails())
		{
			echo var_dump($validator->messages());
			return $this->apiResponse(
				'error',
				$validator->messages(),
				400
			);
		}

		$user = User::find($userId);

		if (! $user)
		{
			return $this->apiResponse(
				'error',
				"User {$userId} not found.",
				404
			);
		}

		$user->fill(Input::get());

		if (! $user->save())
		{
			return $this->apiResponse(
				'error',
				$user->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$user->toArray(),
			200
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $userId
	 * @return Response
	 */
	public function destroy($userId)
	{
		if (! ($userId == Auth::user()->id))
		{
			return $this->apiResponse(
				'error',
				"User {Auth::id()} attempted to delete user {$userId}.",
				401
			);
		}

		$user = User::find($userId);

		if (! $user)
		{
			return $this->apiResponse(
				'error',
				"User {$userId} not found.",
				404
			);
		}

		$user->delete();

		return $this->apiResponse(
			'success',
			'User {$userId} has been removed',
			204
		);
	}
}
