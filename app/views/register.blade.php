@extends('master')

@section('css')
	<style type="text/css">
		.form-control
		{
			width:30%;
		}
	</style>
@stop

@section('javascript')
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function() {
			jQuery.validator.setDefaults({
				debug: true,
				success: "valid"
			});
			
			$("#registrationForm").validate({
				rules: {
					username: {
						required: true,
						rangelength: [4, 15]
					},
					password: {
						required: true,
						rangelength: [8, 21]
					},
					confpassword: {
						equalTo: "#password"
					},
					email: {
						required: true,
						email: true
					},
					/*gender: {
						required: true
					},*/
					agreement: {
						required: true,
					}
				}
			});
		});
	</script>
@stop

@section('content')
	<form id="registrationForm" name="regForm" class="form-horizontal" role="form" method="POST">
		<div class="form-group">
			<h2 id="forms-horizontal" class="col-sm-3	control-label">Account Creation</h2>
		</div>
		<div class="form-group">
			{{Form::label('usernameLabel', 'Username', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'example1234', 'id' => 'username'))}}
				<p class="help-block">Minimum 4 to 15 characters.</p>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('passwordLabel', 'Password', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password', 'id' => 'password'))}}
				<p class="help-block">Minimum 8 to 21 characters.</p>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('confPasswordLabel', 'Confirm Password', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::password('confpassword', array('class' => 'form-control', 'placeholder' => 'Re-enter password', 'id' => 'confpassword'))}}
			</div>
		</div>
		<div class="form-group">
			{{Form::label('emailLabel', 'E-mail', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'email@example.com', 'id' => 'email'))}}
			</div>
		</div>
		<!--<div class="form-group">
			{{Form::label('gender', 'Gender', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
					{{Form::radio('gender', 'male', false, array('id' => 'male'))}}
					{{Form::label('male', 'Male')}}</br>
					{{Form::radio('gender', 'female', false, array('id' => 'female'))}}
					{{Form::label('male', 'Female')}}
			</div>
		</div>-->
		<div class="form-group">
			{{Form::label('termsOfService', 'Terms of Service', array('class' => 'col-sm-2 control-label'))}}
			<div class="col-sm-10">
				{{Form::checkbox('agreement', 'termsOfService', false, array('id' => 'agreement'))}}
				{{Form::label('agreement', 'I understand that account sharing is prohibited.')}}
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