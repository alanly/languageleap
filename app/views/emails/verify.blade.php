<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('account.verification.title')</h2>
		<div>
			<p>@lang('account.verification.thankyou')</p>
			<p>@lang('account.verification.instruction') {{ link_to_action('RegistrationController@getVerify', Lang::get('account.verification.this'), [$confirmation_code]) }}.</p>
			<p>@lang('account.verification.signature')</p>
		</div>
	</body>
</html>