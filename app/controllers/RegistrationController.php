<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class RegistrationController extends \BaseController {

	protected $users;

	private $inputRules = [
		'password' => 'confirmed|min:6',
	];

	public function __construct(User $users)
	{
		// Define the User dependency.
		$this->users = $users;

		// Define the before filters.
		$this->beforeFilter('@filterAuthenticatedUser');
	}


	public function getIndex()
	{
		return View::make('account.register');
	}


	public function getVerify($confirmationCode)
	{
		if(! $confirmationCode)
		{
			return Redirect::action('RegistrationController@getIndex');
		}

		$user = $this->users->whereConfirmationCode($confirmationCode)->first();

		if (! $user)
		{
			return Redirect::action('RegistrationController@getIndex');
		}

		$user->is_confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		return View::make('account.registration.verified');
	}


	/**
	 * Handles the `post` request from the registration form.
	 */
	public function postIndex()
	{
		$validator = Validator::make(Input::get(), $this->inputRules);

		$input = Input::except('password_confirmation');

		if (Input::has('password'))
		{
			// Hash the password value.
			$input['password'] = Hash::make($input['password']);
		}

		$input['confirmation_code'] = str_random(30);

		$user = $this->users->newInstance($input);

		if (! $user->isValid() || $validator->fails())
		{
			$errors = $user->getErrors();
			$errors->merge($validator->errors());

			return Redirect::back()->withErrors($errors)->withInput();
		}

		$user->save();

		// Send a verification email to the user
		Mail::send(
			'emails.verify',
			['confirmation_code' => $input['confirmation_code']],
			function($message) {
				$message
					->to(Input::get('email'), Input::get('username'))
					->subject('Verify your email address');
			}
		);

		return View::make('account.registration.success');
	}


	/**
	 * Filters requests coming from authenticated users.
	 */
	public function filterAuthenticatedUser($route, $request)
	{
		if (Auth::check())
		{
			return Redirect::to('/')
				->with('action.failed', true)
				->with('action.message', 'You are already logged in. To create a new '.
					'account, please sign out first.'
				);
		}
	}

}