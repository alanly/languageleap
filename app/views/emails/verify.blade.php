<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Verify Your Email Address</h2>
		<div>
			<p>Thank you for registering for <strong>LanguageLeap</strong>!</p>
			<p>In order to activate your account, we will need to confirm your email
			address. To do so, just follow {{ link_to_action('RegistrationController@getVerify', 'this link', [$confirmation_code]) }}.</p>
			<p>&mdash; The LanguageLeap Team</p>
		</div>
	</body>
</html>