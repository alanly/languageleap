@extends('admin.master')


@section('content')

<div class="container">

	{{ Form::open(array('url' => 'admin/video','files' => true)) }}

		<input type="radio" id="comm" name="video_type" value="commercial"/><label>Commercial</label>
		<input type="radio" id="mov" name="video_type" value="movie"/><label>Movie</label>
		<input type="radio" id="show" name="video_type" value="show"/><label>Show</label>
		<br/>
		<select id="movie-select" name="movies" style="display:none">
			<option value="1">American pie</option>
		</select>
		<select id="commercial-select" name="commercials" style="display:none">
			<option value="1">Rogers</option>
		</select>
		<select id="show-select" name="shows" style="display:none">
			<option value="1">The big bang theory</option>
		</select>
		<br/>
		<label for='video'>Video</label> {{ Form::file('video')}} <br/>

		<label for='script'>Script</label> {{ Form::textarea('script')}}<br/><br/>

		{{ Form::submit('submit')}}

	{{ Form::close() }}
</div>
<script type="text/javascript">
	//This is jsut for testing. In reality we will have 1 select with the data loaded through ajax.
	$("#show").change(function () {
		$("#show-select").show();
		$("#movie-select").hide();
		$("#commercial-select").hide();
	});
	$("#mov").change(function () {
		$("#show-select").hide();
		$("#movie-select").show();
		$("#commercial-select").hide();
	});
	$("#comm").change(function () {
		$("#show-select").hide();
		$("#movie-select").hide();
		$("#commercial-select").show();
	});
</script>


@stop