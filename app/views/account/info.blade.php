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
		font-weight: bold;
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
				<h1>@lang('account.info.title')<small><br/>@lang('account.info.subtitle')</small></h1>
			</div>
		</div>
	</div>

	<br/>

	<div class="row">
		<form role="form" id="user-update-form">
			<div class="col-lg-6">
				<div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>@lang('account.info.required')</strong></div>
				
				<div class="form-group">
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputName">@lang('account.info.fname')</label>
						<div class="input-group">
							<input value="{{ $data['fname'] }}" type="text" class="form-control" name="first_name" id="first_name" placeholder="@lang('account.info.fname')" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
						</div>
					</div>
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputName">@lang('account.info.lname')</label>
						<div class="input-group">
							<input value="{{ $data['lname'] }}"  type="text" class="form-control" name="last_name" id="last_name" placeholder="@lang('account.info.lname')" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputEmail">@lang('account.info.email')</label>
						<div class="input-group">
							<input value="{{ $data['email'] }}"  type="email" class="form-control" id="InputEmail" name="email" placeholder="Enter New Email">
						</div>
					</div>
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputEmail">@lang('account.info.lang')</label>
						<div class="input-group">
							<select name="language" id="InputEmail" class="form-control">
								@foreach($langs as $lang)
									<option value="{{ $lang->id }}">{{ $lang->description }}</option>
								@endforeach
							</select>
						</div>
					</div> 
				</div>

				<div class="form-group">	
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputEmail">@lang('account.info.pass')</label>
						<div class="input-group">
							<input type="password" class="form-control" id="InputPassword" name="new_password" placeholder="@lang('account.info.pass')">
						</div>
					</div>                
					<div class="input col-sm-6 col-md-6 col-lg-6">
						<label for="InputEmail">@lang('account.info.pass2')</label>
						<div class="input-group">
							<input type="password" class="form-control" id="InputConfirmPassword" name="new_password_confirmation" placeholder="@lang('account.info.pass2')">
						</div>
					</div>  
				</div>

				<div class="form-group">
					<label for="InputEmail">@lang('account.info.cpass')</label>
					<div class="input-group">
						<input type="password" class="form-control" id="ConfirmPassword" name="password" placeholder="@lang('account.info.cpass')" required="">
						<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
					</div>
				</div>
				<input type="button" name="submit" id="submit" value="@lang('account.info.submit')" class="btn btn-info pull-right">
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">

	$('#submit').on("click", function()
	{
		var form_data = $("#user-update-form").serialize();

		$.ajax({
			type: 'PUT',
			url : '/api/users/user',
			dataType: "json",
			data: form_data,
			success: function(data)
			{  	
				$('#alert').attr('class','alert alert-success');
				$('#alert-text').text("Success! Changes were made!");
				$('#alert-glyph').attr('class','glyphicon glyphicon-ok');			
			},
			error: function(data)
			{  	
				$('#alert').attr('class','alert alert-danger');
				
				var errors = "";
				
				//Get all the errors sent back.
				for(var i = 0; i< data.responseJSON.data.length; i++){
					errors += data.responseJSON.data[i] + "<br/>";
				}

				$('#alert-text').html(errors);
				
				$('#alert-glyph').attr('class','glyphicon glyphicon-exclamation-sign');				
			}
		});
	});
</script>
@stop
