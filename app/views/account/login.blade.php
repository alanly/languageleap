@extends('account.master')

@section('page.name')
@lang('auth.login.page_name')
@stop

@section('body')
	<div class="container">
		<a class="auth-switch-link btn btn-md btn-frosted" href="{{ action('RegistrationController@getIndex') }}">@lang('auth.login.create_account')</a>
	</div>

	<div class="form-container">
		{{
			Form::open([
				'action' => 'AuthController@postLogin',
				'id'     => 'login-form',
				'class'  => 'col-sm-4 col-lg-2 centered-box',
			]) 
		}}
			<div>
				<h3 class="brand">Language Leap</h3>
			</div>
			@if (Session::get('action.failed') === true)
			<div class="alert-message alert alert-danger">
				<p>{{{ Session::get('action.message', Lang::get('auth.login.form_errors')) }}}</p>
			</div>
			@endif
			<div class="form-group input-group">
				{{
					Form::text(
						'username',
						Input::old('username'),
						[
							'id'          => 'username-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.login.fields.placeholders.username'),
							'required'    => 'required'
						]
					)
				}}
				{{
					Form::password(
						'password',
						[
							'id'          => 'password-field',
							'class'       => 'form-control input-lg',
							'placeholder' => Lang::get('auth.login.fields.placeholders.password'),
							'required'    => 'required'
						]
					)
				}}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-lg btn-frosted">@lang('auth.login.fields.submit')</button>
				<div class="checkbox">
					<label id="remember-label" onclick="clickRememberCheckbox()">
						{{
							Form::checkbox(
								'remember',
								Input::old('remember', 0),
								null,
								[
									'id'    => 'remember-checkbox',
									'class' => 'hide'
								]
							) 
						}}
						<i id="remember-icon" class="fa fa-fw fa-square-o"></i>
						@lang('auth.login.fields.remember')
					</label>
				</div>
			</div>
		{{ Form::close() }}
	</div>

	<script>
		function clickRememberCheckbox() {
			var checkbox = document.getElementById('remember-checkbox');
			var icon = document.getElementById('remember-icon');

			checkbox.checked = ! checkbox.checked;

			if (checkbox.checked === true) {
				icon.className = 'fa fa-fw fa-check-square-o';
			} else {
				icon.className = 'fa fa-fw fa-square-o';
			}
		}
	</script>
@stop