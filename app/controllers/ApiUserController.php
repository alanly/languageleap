<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiUserController extends \BaseController {

	protected $users;

	public function __construct(User $users)
	{
		$this->users = $users;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
	
		return $this->apiResponse("success", $users->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
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
		$users = User::find($userId);
		
		if (!$users)
		{
			return $this->apiResponse(
				'error',
				"User {$userId} not found.",
				404
			);
		}
		
		return $this->apiResponse("success", $users->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $userId
	 * @return Response
	 */
	public function update($userId)
	{
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
