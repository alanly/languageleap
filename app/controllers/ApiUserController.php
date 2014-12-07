<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiUserController extends \BaseController {

	protected $users;

	private $inputRules = [
		'username' => 'alpha_dash',
		'email'    => 'email',
		'password' => 'min:6',
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
			return $this->apiResponse('error', "User is already logged in", 403);
		}

		$validator = Validator::make(Input::get(), $this->inputRules);

		if ($validator->fails())
		{
			return $this->apiResponse('error', $validator->messages(), 400);
		}

		$input = Input::all();
		$input['password'] = Hash::make($input['password']); // Hash the password value.

		$user = $this->users->newInstance($input);

		if (! $user->save())
		{
			return $this->apiResponse('error', $user->getErrors(), 400);
		}

		return $this->apiResponse('success', $user->toArray(), 201);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  int  $userId
	 * @return JsonResponse
	 */
	public function show($userId)
	{
		if ($userId != Auth::user()->id)
		{
			return $this->apiResponse(
				'error',
				"User ".Auth::user()->id." attempted to access user {$userId}.",
				401
			);
		}

		$user = $this->users->find($userId);
		
		if (! $user)
		{
			return $this->apiResponse(
				'error',
				"User {$userId} not found.",
				404
			);
		}
		
		return $this->apiResponse('success', $user->toArray(), 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $userId
	 * @return Response
	 */
	public function update($userId)
	{
		if ($userId != Auth::user()->id)
		{
			return $this->apiResponse(
				'error',
				"User ".Auth::user()->id." attempting to modify user {$userId}.",
				401
			);
		}

		$validator = Validator::make(Input::get(), $this->inputRules);

		if ($validator->fails())
		{
			return $this->apiResponse('error', $validator->messages(), 400);
		}

		$user = $this->users->find($userId);

		if (! $user)
		{
			return $this->apiResponse('error', "User {$userId} not found.", 404);
		}

		$user->fill(Input::get());

		if (! $user->save())
		{
			return $this->apiResponse('error', $user->getErrors(), 400);
		}

		return $this->apiResponse('success', $user->toArray(), 200);
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
