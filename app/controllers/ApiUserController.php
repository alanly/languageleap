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
		// Define the User dependency.
		$this->users = $users;

		// Define the before filters.
		$this->beforeFilter('@filterAuthenticatedUser', ['only' => 'store']);
		$this->beforeFilter('@filterModifyingAnotherUser', ['except' => 'store']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::get(), $this->inputRules);

		if ($validator->fails())
		{
			return $this->apiResponse('error', $validator->messages(), 400);
		}

		$input = Input::all();

		if (isset($input['password']))
		{
			$input['password'] = Hash::make($input['password']); // Hash the password value.
		}

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
		$user = $this->users->find($userId);
		
		if (! $user)
		{
			return $this->apiResponse('error', "User {$userId} not found.", 404);
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
		$user = $this->users->find($userId);

		if (! $user)
		{
			return $this->apiResponse('error', "User {$userId} not found.", 404);
		}

		if (! $user->delete())
		{
			return $this->apiResponse('error', "Unable to delete user {$userId}.", 500);
		}

		return $this->apiResponse('success', 'User has been removed.', 204);
	}


	/**
	 * Filters requests coming from authenticated users.
	 */
	public function filterAuthenticatedUser($route, $request)
	{
		if (Auth::check())
		{
			return $this->apiResponse('error', "User is authenticated.", 403);
		}
	}


	/**
	 * Filters requests for modifying another user.
	 */
	public function filterModifyingAnotherUser($route, $request)
	{
		// Get the ID parameter from the route.
		$id = $route->getParameter('users');

		if ($id != Auth::user()->id)
		{
			return $this->apiResponse(
				'error',
				"User ".Auth::user()->id." attempting to modify user {$id}.",
				401
			);
		}
	}

}
