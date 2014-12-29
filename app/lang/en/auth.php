<?php

return [

	'login' => [
		'form_errors'    => 'The username and/or password you entered is incorrect or does not belong to an existing account.',
		'create_account' => 'Create an account',
		'page_name'      => 'Log in',
		'fields' => [
			'submit' => 'Log in',
			'remember' => 'Remember me',
			'placeholders' => [
				'username' => 'Username',
				'password' => 'Password',
			]
		],
	],

	'register' => [
		'form_errors'   => 'There is an error in your form, please fix it and try again.|There are errors in your form, please fix them and try again.',
		'login_account' => 'Log in to my account',
		'page_name'     => 'Create an account',
		'success'       => 'Your account has been created, but before you can log in, you must confirm your email address by following the link that\'s been emailed to you.',
		'fields' => [
			'submit' => 'Create an account',
			'placeholders' => [
				'username'              => 'Username',
				'password'              => 'Password',
				'password_confirmation' => 'Confirm password',
				'email'                 => 'Email',
				'first_name'            => 'First name',
				'last_name'             => 'Last name',
			],
			'titles' => [
				'username'              => 'Usernames can consist of alphanumerics as well as dashes and underscores.',
				'password'              => 'Passwords can consist of any characters, with a minimum length of 6.',
				'password_confirmation' => 'Must match the password entered above.',
				'email'                 => 'Must be a valid email address; you will receive a confirmation link at this address.',
				'first_name'            => 'Your first name.',
				'last_name'             => 'Your last name.',
			],
		],
	],

	'verify' => [
		'activated' => 'Your account has been activated! You can now proceed to log in to your account.',
		'incorrect' => 'The confirmation link you followed was invalid.',
	],

	'logout' => [
		'success' => 'You have logged out.',
		'error'   => 'An error occured while attempting to log out. Please try again.',
	],

];
