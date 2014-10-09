@extends('admin.master')


@section('content')

<div class="container">

	{{ Form::open(array('url' => 'api/metadata/videos','files' => true)) }}

		<input type="radio" id="comm" name="video_type" value="commercial"/><label>Commercial</label>
		<input type="radio" id="mov" name="video_type" value="movie"/><label>Movie</label>
		<input type="radio" id="show" name="video_type" value="show"/><label>Show</label>
		<br/>

		<select id="movie-select" name="movie" style="display:none">
		</select>
		<select id="commercial-select" name="commercial" style="display:none">
		</select>
		<select id="show-select" name="shows" style="display:none">
			<option value="-1"></option>
		</select>

		<select id="season-select" name="season" style="display:none;">
			<option value="-1"></option>
		</select>
		<select id="episode-select" name="episode" style="display:none;">
		</select>
		<br/>
		<label for='video'>Video</label> {{ Form::file('video')}} <br/>

		<label for='script'>Script</label> {{ Form::textarea('script')}}<br/><br/>

		{{ Form::submit('submit')}}

	{{ Form::close() }}
</div>
<script type="text/javascript">
	//This is just for testing. In reality we will have 1 select with the data loaded through ajax.
	$("#show").change(function () {
		$("#show-select").show();
		$("#movie-select").hide();
		$("#commercial-select").hide();
		loadShowContent();
	});
	$("#mov").change(function () {
		$("#show-select").hide();
		$("#movie-select").show();
		$("#commercial-select").hide();
		loadMovieContent();
	});
	$("#comm").change(function () {
		$("#show-select").hide();
		$("#movie-select").hide();
		$("#commercial-select").show();
		loadCommercialContent();
	});

	$("#show-select").change(function(){
		$("#season-select").show();
		loadSeasonContent($(this).val());
	});
	$("#season-select").change(function(){
		$("#episode-select").show();
		loadEpisodeContent($("#show-select").val(), $("#season-select").val());
	});


	function loadEpisodeContent(show_id,season_id){

		$.getJSON("/api/metadata/shows/" + show_id + "/seasons/" + season_id + "/episodes" ,function(data){
			
		});
	}

	function loadSeasonContent(show_id){
		$.getJSON("/api/metadata/shows/" + show_id + "/seasons",function(data){
			if(data.status == "success")
			{
				var json = data.data.seasons;
				var option = "";
				$.each(json,function(index,value){
					option += '<option value="' + value.id + ' ">'+ value.number + '</option>';
				});
				$("#season-select").append(option);
			}
			else
			{
				alert("Unable to load season");
			}
			
		});
	}
	function loadShowContent(){
		$.getJSON("/api/metadata/shows",function(data){
			if(data.status == "success")
			{
				var json = data.data;
				var option = "";
				$.each(json,function(index,value){
					option += '<option value="' + value.id + ' ">'+ value.name + '</option>';
				});
				$("#show-select").append(option);
			}
			else
			{
				alert("Unable to load shows");
			}
			
		});
	}
	function loadMovieContent(){
		$.getJSON("/api/metadata/movies",function(data){
			if(data.status == "success")
			{
				var json = data.data;
				var option = "";
				$.each(json,function(index,value){
					option += '<option value="' + value.id + ' ">'+ value.name + '</option>';
				});
				$("#movie-select").append(option);
			}
			else
			{
				alert("Unable to load movies");
			}
			
		});
	}
		function loadCommercialContent(){
		$.getJSON("/api/metadata/commercials",function(data){
			if(data.status == "success")
			{
				var json = data.data;
				var option = "";
				$.each(json,function(index,value){
					option += '<option value="' + value.id + ' ">'+ value.name + '</option>';
				});
				$("#commercial-select").append(option);
			}
			else
			{
				alert("Unable to load movies");
			}
			
		});
	}
</script>


@stop