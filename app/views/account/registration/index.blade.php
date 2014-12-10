@extends('master')

@section('css')
<style>
	body {
		padding-top: 3rem;
	}
	.reg-form {
		padding-top: 3rem;
	}
</style>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-center">Create an account today!</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
				{{ Form::open(['url' => 'register', 'class' => 'form-horizontal reg-form', 'role' => 'form']) }}
					<div class="form-group">
						{{ Form::label('first_name', 'First Name', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::text('first_name', Input::old('first_name'), ['class' => 'form-control', 'placeholder' => 'e.g. Jane', 'required' => 'required']) }}
							<p class="help-block danger">{{ $errors->first('first_name') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('last_name', 'Last Name', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::text('last_name', Input::old('last_name'), ['class' => 'form-control', 'placeholder' => 'e.g. Smith', 'required' => 'required']) }}
							<p class="help-block danger">{{ $errors->first('last_name') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('username', 'Username', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'e.g. jane_smith_72', 'required' => 'required']) }}
							<p class="help-block danger">{{ $errors->first('username') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('email', 'Email Address', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::email('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'e.g. jane@smith.com', 'required' => 'required']) }}
							<p class="help-block danger">{{ $errors->first('email') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('password', 'Password', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Desired password...', 'required' => 'required', 'pattern' => '.{6,}', 'minlength' => '6', 'title' => 'Required. Minimum length of 6 characters.']) }}
							<p class="help-block danger">{{ $errors->first('password') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-4 control-label']) }}
						<div class="col-sm-8">
							{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repeat password...', 'required' => 'required']) }}
							<p class="help-block danger">{{ $errors->first('password_confirmation') }}</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							{{ Form::submit('Register', ['class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop