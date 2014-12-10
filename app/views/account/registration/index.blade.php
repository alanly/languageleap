@extends('master')

@section('content')
	<div class="container">
		{{ Form::open(['url' => 'register', 'class' => 'form-horizontal', 'role' => 'form']) }}
			<div class="form-group">
				{{ Form::label('first_name', 'First name', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-3">
					{{ Form::text('first_name', Input::old('first_name'), ['class' => 'form-control', 'placeholder' => 'First name']) }}
					
				</div>
				<span class="help-block">{{ $errors->first('first_name') }}</span>
			</div>
			<div class="form-group">
				{{ Form::label('last_name', 'Last name', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-3">
					{{ Form::text('last_name', Input::old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last name']) }}
				</div>
				<span class="help-block">{{ $errors->first('last_name') }}</span>
			</div>
			<div class="form-group">
				{{ Form::label('username', 'Username', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-2">
					{{ Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'Username']) }}
				</div>
				<span class="help-block">{{ $errors->first('username') }}</span>
			</div>
			<div class="form-group">
				{{ Form::label('email', 'Email address', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-4">
					{{ Form::email('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
				</div>
				<span class="help-block">{{ $errors->first('email') }}</span>
			</div>
			<div class="form-group">
				{{ Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-2">
					{{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
				</div>
				<span class="help-block">{{ $errors->first('password') }}</span>
			</div>
			<div class="form-group">
				{{ Form::label('password_confirmation', 'Confirm password', ['class' => 'col-sm-2 control-label']) }}
				<div class="col-sm-2">
					{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password']) }}
				</div>
				<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					{{ Form::submit('Register', ['class' => 'btn btn-default']) }}
				</div>
			</div>
		{{ Form::close() }}
	</div>
@stop