@extends('master')

@section('css')
	<style>
		.form-control
		{
			width:30%;
		}
	</style>
@stop

@section('javascript')
@stop

@section('content')
	<form class="form-horizontal" role="form">
		<div class="form-group">
			<h2 id="forms-horizontal" class="col-sm-3	control-label">Account Creation</h2>
		</div>
		<div class="form-group">
			{{Form::label('usernameLabel', 'Username', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::text('username', '' , array('class' => 'form-control', 'placeholder' => 'example1234', 'id' => 'usernameInput'))}}
				<p class="form-control-static">You will use this to login</p>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('password', 'Password', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password', 'id' => 'passwordInput'))}}
				<p class="form-control-static">Minimum 6 to 12 characters maximum.</p>
			</div>
			{{Form::label('confPassword', 'Confirm Password', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::password('confpassword', array('class' => 'form-control', 'placeholder' => 'Re-enter password', 'id' => 'confpasswordInput'))}}
			</div>
		</div>
		<div class="form-group">
			{{Form::label('email', 'E-mail', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'email@example.com', 'id' => 'emailInput'))}}
				<p class="form-control-static">You will receive emails regarding taking quizzes</p>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('gender', 'Gender', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
					{{Form::radio('gender', 'male', false, array('id' => 'male'))}}
					{{Form::label('male', 'Male')}}</br>
					{{Form::radio('gender', 'female', false, array('id' => 'female'))}}
					{{Form::label('male', 'Female')}}
			</div>
		</div>
		<div class="form-group">
			{{Form::label('termsOfService', 'Terms of Service', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::checkbox('agreement', 'termsOfService', false, array('id' => 'terms'))}}
				{{Form::label('tos', 'I agree that this account belongs to me and me only. I understand that account sharing is prohibited.', array('class' => 'text'))}}
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 control-label">
				{{Form::submit('Register', array('class' => 'btn btn-default'))}}
			</div>
			<div class="col-sm-1 control-label">
				{{Form::reset('Reset fields', array('class' => 'btn btn-default'))}}
			</div>
		</div>
	</form>			
@stop