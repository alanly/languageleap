<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('emails.password_reset.header')</h2>

		<div>
			@lang('emails.password_reset.instructions'): {{ URL::to('password/reset', array($token)) }}.<br/>
			@lang('emails.password_reset.link_expiry') {{ Config::get('auth.reminder.expire', 60) }} @lang('emails.password_reset.expiry_minutes').
		</div>
	</body>
</html>
