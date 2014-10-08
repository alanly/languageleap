@extends('master')


@section('content')
<div class="container">

	{{ Form::open(array('url' => 'admin/video','files' => true)) }}

		<label for='video'>Video</label> {{ Form::file('video')}} <br/>

		<label for='script'>Script</label> {{ Form::textarea('script')}}<br/><br/>

		{{ Form::submit('submit')}}

	{{ Form::close() }}
</div>

@stop