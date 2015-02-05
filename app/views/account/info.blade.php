@extends('master')

@section('css')
<style type="text/css">
	.login-form {
		min-width: 300px;
		padding: 15px 30px 15px 30px;
		margin: 15% auto;
		width: 30%;
		border: solid 1px #d4d4d4;
	}
	.brand {
		font-weight: 800 !important;
		padding: 10px 10px 10px 10px;
		text-align: center;
	}

	.input 
	{
		padding-bottom: 30px;
	}

</style>
@stop

@section('content')
<div class="container">
    <div class="page-header">

        <!--
        <div class="col-lg-5 col-md-push-1">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span> Success! Message sent.</strong>
                </div>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Please check all page inputs.</strong>
                </div>
            </div>
        </div>-->

        <div class="clearfix">
            <div class="col-md-12">
                <h1>Personal Information <small><br/>Review and Change your personal information.</small></h1>
            </div>
        </div>
    </div>
    <br>
    <div class="clearfix">
        <div class="container">
    <div class="row">
        <form role="form">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                
                <div class="form-group">
                    <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputName">First Name</label>
	                    <div class="input-group">
	                        <input value="{{ $data['fname'] }}" type="text" class="form-control" name="InputName" id="InputFirstName" placeholder="Enter First Name" required="" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
	                    </div>
	                </div>
                    <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputName">Last Name</label>
	                    <div class="input-group">
	                        <input value="{{ $data['lname'] }}"  type="text" class="form-control" name="InputName" id="InputLastName" placeholder="Enter Last Name" required="" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
	                    </div>
	                </div>
                </div>

                <div class="form-group">
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Enter New Email</label>
	                    <div class="input-group">
	                        <input value="{{ $data['email'] }}"  type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter New Email" required="">
	                    </div>
	                </div>
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Confirm New Email</label>
	                    <div class="input-group">
	                        <input type="email" class="form-control" id="InputEmailConfirm" name="InputEmail" placeholder="Confirm New Email" required="">
	                    </div>
	                </div>  
	            </div>

	            <div class="form-group">	
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Enter New Password</label>
	                    <div class="input-group">
	                        <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="Enter New Password" required="">
	                    </div>
	                </div>                
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Confirm New Password</label>
	                    <div class="input-group">
	                        <input type="password" class="form-control" id="InputPasswordConfirm" name="InputPassword" placeholder="Confirm New Password" required="">
	                    </div>
	                </div>  
	            </div>

                <div class="form-group">
                    <label for="InputEmail">Enter your current password to confirm changes</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="InputEmailSecond" name="InputEmail" placeholder="Enter current password" required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>
        </form>
    </div>
</div>

<script>

$('#submit').on("click", function()
{
	var fname = $('#InputFirstName').attr('value');
	var lname = $('#InputLastName').attr('value');
	
	var email = $('#InputEmail').attr('value');

	var password = $('#InputPassword').attr('value');

	var submitPassword = $('#InputPasswordConfirm').attr('value');

	var emailChange = false;
	var passChange = false;

	var errorMessage = "";

	if($data['fname'] == fname)
	{
		fname = ""; 
	}

	if($data['lname'] == lname)
	{
		lname = "";
	}

	if($data['email'] != email)
	{		
		emailChange = (email == $('#InputEmailConfirm').attr('value'));
	}

	if($data['password'] != password)
	{
		passChange = (password == $('#InputPasswordConfirm').attr('value'));
	}
	
	$.ajax({
		type: 'POST',
		url : '/api/user/',

		dataType: "json",
		data:
		{
			'fname': fname,
			'lname': lname,
			'email': email,
			'password': password,
			'submit_password': submitPassword
		},
		success: function(data)
		{  

		}
	});


});

</script>
@stop
