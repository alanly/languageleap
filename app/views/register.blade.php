@extends('master')
@section('css')
	<style>
		.form-control
		{
			width:30%;
		}
	</style>
@stop
@section('content')
	<form class="form-horizontal" role="form">
		<div class="form-group">
			<h2 id="forms-horizontal" class="col-sm-3	control-label">Account Creation</h2>
		</div>
		<div class="form-group">
			<label for="inputUsername" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="inputUsername" placeholder="example1234">
				<p class="form-control-static">You will use this to login</p>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="inputPassword" placeholder="Password">
				<p class="form-control-static">Minimum 6 to 12 characters maximum.</p>
			</div>
			<label for="inputPassword" class="col-sm-2 control-label">Re-enter Password</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="confPassword" placeholder="Confirm Password">
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="inputEmail" placeholder="email@example.com">
				<p class="form-control-static">You will receive emails regarding taking quizzes</p>
			</div>
		</div>
		<div class="form-group">
			<label for="genderInput" class="col-sm-2 control-label">Gender</label>
			<div class="col-sm-10">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
						Male
					</label></br>
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
						Female
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="termsOfService" class="col-sm-2 control-label">Terms of Service</label>
			<div class="col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="tos" id="tos1">
						I agree that this account belongs to me and me only. I understand that account sharing is prohibited.
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 control-label">
				<button type="submit" class="btn btn-default">Register</button>
			</div>
			<div class="col-sm-1 control-label">
				<button type="reset" class="btn btn-default">Reset Fields</button>
			</div>
		</div>
	</form>			
@stop