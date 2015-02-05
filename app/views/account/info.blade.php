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

        
        <div id="alert" class="alert">
            <strong id="alert-text"><span id="alert-glyph" class="glyphicon"></span></strong>
        </div>

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
	                        <input value="{{ $data['fname'] }}" type="text" class="form-control" name="InputName" id="InputFirstName" placeholder="Enter First Name" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
	                    </div>
	                </div>
                    <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputName">Last Name</label>
	                    <div class="input-group">
	                        <input value="{{ $data['lname'] }}"  type="text" class="form-control" name="InputName" id="InputLastName" placeholder="Enter Last Name"style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
	                    </div>
	                </div>
                </div>

                <div class="form-group">
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Enter New Email</label>
	                    <div class="input-group">
	                        <input value="{{ $data['email'] }}"  type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter New Email">
	                    </div>
	                </div>
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Select Language</label>
		                <div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="langDropdownMenu" data-toggle="dropdown" aria-expanded="true">
							Language
							<span class="caret"></span>
							</button>
							<ul class="language-drop dropdown-menu" role="menu" aria-labelledby="langDropdownMenu">
							</ul>
						</div>
					</div> 
	            </div>

	            <div class="form-group">	
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Enter New Password</label>
	                    <div class="input-group">
	                        <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="Enter New Password">
	                    </div>
	                </div>                
	                <div class="input col-sm-6 col-md-6 col-lg-6">
	                    <label for="InputEmail">Confirm New Password</label>
	                    <div class="input-group">
	                        <input type="password" class="form-control" id="InputConfirmPassword" name="InputPassword" placeholder="Confirm New Password">
	                    </div>
	                </div>  
	            </div>

                <div class="form-group">
                    <label for="InputEmail">Enter your current password to confirm changes</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="ConfirmPassword" name="InputPassword" placeholder="Enter current password" required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="button" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>
        </form>
    </div>
</div>

<script>

$(document).ready( function() 
{
	$.each({{$langs}}, function( index, language ) 
	{
		var anchor = $("<a role=\"menuitem\" tabindex=\"-1\" href=\"#\");></a>").text(language["description"]);
		anchor.attr("onclick", "updateSelected(\"" + anchor.text() + "\", " + language["id"] + ")");
		var lang = $("<li role=\"presentation\"></li>");

		lang.append(anchor);
		$('.language-drop').append(lang);	
	});
});

function updateSelected(lang, id)
{
	$('#langDropdownMenu').text(lang);
	$('#langDropdownMenu').attr('name', id)
}

$('#submit').on("click", function()
{

	$.ajax({
		type: 'POST',
		url : '/api/user/update-user-info',

		dataType: "json",
		data:
		{
			'first_name': $('#InputFirstName').attr('value'),
			'last_name': $('#InputLastName').attr('value'),
			'new_email': $('#InputEmail').attr('value'),
			'language_id': $('#langDropdownMenu').attr('name'),
			'current_password': $('#ConfirmPassword').attr('value')
		},
		success: function(data)
		{  	
			$('#alert').attr('class','alert alert-success');
			$('#alert-text').text("Success! Changes were made!");
			$('#alert-glyph').attr('class','glyphicon glyphicon-ok');			
		},
		error: function(data)
		{  	
			$('#alert').attr('class','alert alert-danger');
			$('#alert-text').text("Failure!");
			$('#alert-glyph').attr('class','glyphicon glyphicon-exclamation-sign');				
		}
	});

	$.ajax({
		type: 'POST',
		url : '/api/user/update-password',

		dataType: "json",
		data:
		{
			'new_password': $('#InputPassword').attr('value'),
			'new_password_again': $('#InputConfirmPassword').attr('value'),
			'current_password': $('#ConfirmPassword').attr('value')
		},
		success: function(data)
		{  	
			$('#alert').attr('class','alert alert-success');
			$('#alert-text').text("Success! Changes were made!");
			$('#alert-glyph').attr('class','glyphicon glyphicon-ok');			
		},
		error: function(data)
		{  	
			$('#alert').attr('class','alert alert-danger');
			$('#alert-text').text("Failure!");
			$('#alert-glyph').attr('class','glyphicon glyphicon-exclamation-sign');				
		}
	});
});

</script>
@stop
