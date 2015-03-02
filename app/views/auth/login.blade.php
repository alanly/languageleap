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
</style>
@stop

@section('content')
<div class="container login-form">
	<h3 class="brand">@lang('sitename.name.no_space')</h3>

	@if(Session::has('action.failed') === true)
		<div class="alert {{ Session::get('action.failed') === false ? 'alert-info' : 'alert-danger' }}">
			<p>{{ Session::get('action.message') }}</p>
		</div>
	@endif
	
	<div class="row">
		{{ Form::open(array('action' => 'AuthController@postLogin', 'class' => 'form-horizontal', 'placeholder' => 'form')) }}
			<div class="form-group">
				{{ Form::label('Username','', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-10">
					{{ Form::text('username','',array('class' => 'form-control', 'placeholder' => 'Username')) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('Password','', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-10">
					{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							{{ Form::checkbox('remember') }} Remember me
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop