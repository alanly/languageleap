<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class RegistrationController extends \BaseController {

	protected $users;

	private $inputRules = [
		'username' => 'alpha_dash',
		'email'    => 'email',
		'password' => 'required|confirmed|min:6',
	];

	public function __construct(User $users)
	{
		// Define the User dependency.
		$this->users = $users;

		// Define the before filters.
		$this->beforeFilter('@filterAuthenticatedUser');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::get(), $this->inputRules);

		$input = Input::except('password_confirmation');

		if (isset($input['password']))
		{
			$input['password'] = Hash::make($input['password']); // Hash the password value.
		}

		$input['confirmation_code'] = str_random(30);

		$user = $this->users->newInstance($input);

		if (! $user->isValid() || $validator->fails())
		{
			$errors = $user->getErrors();
			$errors->merge($validator->errors());
			return Redirect::to('register')->withErrors($errors)->withInput();
		}

		$user->save();

		// Send a verification email to the user
		Mail::send('emails.verify', ['confirmation_code' => $input['confirmation_code']], function($message) {
			$message->to(Input::get('email'), Input::get('username'))
			->subject('Verify your email address');
		});

		return Redirect::to('register/success');
	}


	/**
	 * Filters requests coming from authenticated users.
	 */
	public function filterAuthenticatedUser($route, $request)
	{
		if (Auth::check())
		{
			return Redirect::to('register')->withErrors('You are already logged in.');
		}
	}


	/**
	* Attempt to confirm the user with the provided confirmation code.
	*/
	public function confirm($confirmation_code)
	{
		if(! $confirmation_code)
		{
			return Redirect::to('register');
		}

		$user = User::whereConfirmationCode($confirmation_code)->first();

		if (! $user)
		{
			return Redirect::to('register');
		}

		$user->is_confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		return Redirect::to('register/verified');
	}

}