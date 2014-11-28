@extends('master')

@section('content')
	<div class="container">
		@if(Session::has('action.failed') === true)
			<div class="alert {{ Session::get('action.failed') === false ? 'alert-info' : 'alert-danger' }}">
				<p>{{ Session::get('action.message') }}</p>
			</div>
		@endif

		<div class="row">
			{{ Form::open(array('url' => '/auth/login', 'class' => 'form-horizontal', 'placeholder' => 'form')) }}
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
						{{ Form::submit('Sign in', array('class' => 'btn btn-default')) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop()