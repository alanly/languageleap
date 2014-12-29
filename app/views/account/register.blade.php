@extends('account.master')

@section('page.name')
@lang('auth.register.page_name')
@stop

@section('body')
	<div class="container">
		<a class="auth-switch-link btn btn-md btn-frosted" href="{{ action('AuthController@getLogin') }}">@lang('auth.register.login_account')</a>
	</div>

	<div class="form-container">
		{{
			Form::open([
				'action' => 'RegistrationController@postIndex',
				'id'     => 'registration-form',
				'class'  => 'col-sm-4 col-lg-2 centered-box',
			])
		}}
			<div class="form-group">
				<h3 class="brand">Language Leap</h3>
			</div>
			@unless ($errors->isEmpty())
			<div class="alert-message alert alert-danger">
				<p>@choice('auth.register.form_errors', $errors->count())</p>
			</div>
			@endunless
			<div class="form-group input-group">
				{{
					Form::text(
						'username',
						Input::old('username'),
						[
							'id'          => 'username-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.username'),
							'required'    => 'required',
							'pattern'     => '[\w\-]+',
							'title'       => Lang::get('auth.register.fields.titles.username'),
						]
					)
				}}
				{{
					Form::password(
						'password',
						[
							'id'          => 'password-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.password'),
							'required'    => 'required',
							'pattern'     => '.{6,}',
							'title'       => Lang::get('auth.register.fields.titles.password'),
						]
					)
				}}
				{{
					Form::password(
						'password_confirmation',
						[
							'id'          => 'password-confirmation-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.password_confirmation'),
							'required'    => 'required',
							'pattern'     => '.{6,}',
							'title'       => Lang::get('auth.register.fields.titles.password_confirmation'),
						]
					)
				}}
			</div>
			<div class="form-group input-group">
				{{
					Form::text(
						'email',
						Input::old('email'),
						[
							'id'          => 'email-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.email'),
							'required'    => 'required',
							'title'       => Lang::get('auth.register.fields.titles.email'),
						]
					)
				}}
				{{
					Form::text(
						'first_name',
						Input::old('first_name'),
						[
							'id'          => 'first-name-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.first_name'),
							'required'    => 'required',
							'title'       => Lang::get('auth.register.fields.titles.first_name'),
						]
					)
				}}
				{{
					Form::text(
						'last_name',
						Input::old('last_name'),
						[
							'id'          => 'last-name-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.register.fields.placeholders.last_name'),
							'required'    => 'required',
							'title'       => Lang::get('auth.register.fields.titles.last_name'),
						]
					)
				}}
			</div>
			<div class="form-group input-group">
				<button type="submit" class="btn btn-lg btn-frosted">@lang('auth.register.fields.submit')</button>
			</div>
		{{ Form::close() }}
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@stop