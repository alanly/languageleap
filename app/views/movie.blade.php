@extends('master')

@section('css')
	<style>
		.cover img {
			height: 300px;
			width: 225px;
		}

		.thumbnail.cover {
			width: 225px;
		}

		.video-selection tbody tr td {
			vertical-align: middle;	
		}
	</style>
@stop

@section('javascript')

	<script src="/js/media.js"></script>	

@stop

@section('content')
	<div class="container">
		<h2 id="movie-title"></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img id="movie-image" src="http://placehold.it/225x300" />
				</div>
			</div>
			<div class="col-md-9">
				<span class="level">
					<h3>@lang('index.layout.general.difficulty')</h3>
					<p id="movie-level"></p>
				</span>
				<div class="row">
					<span class="director col-md-4 col-xs-6">
						<h3>@lang('index.layout.movie.director')</h3>
						<p id="movie-director"></p>
					</span>
					<span class="starring col-md-4 col-xs-6">
						<h3>@lang('index.layout.movie.starring')</h3>
						<p id="movie-actors"></p>
					</span>
				</div>
				<span class="description">
					<h3>@lang('index.layout.general.description')</h3>
					<p id="movie-description"></p>
				</span>
				<br>
				<span class="video-selection">
					<div class="panel panel-default">
						<!-- Table -->
						<table class="table table-hover">
							<thead>
								<tr>
									<th>@lang('index.layout.general.part_number')</th>
									<th>@lang('index.layout.general.length')</th>
									<th>@lang('index.layout.general.play')</th>
									<th>@lang('index.layout.general.score')</th>
								</tr>
							</thead>
							<tbody id="movie-videos">
							
							</tbody>	
						</table>
					</div>
				</span>
			</div>
		</div>
	</div>
	<div class="error" style="display:none;">
		<div class="alert alert-danger" role="alert" id="movie-error">
			
		</div>
	</div>
	<script type="text/javascript">
			$(document).ready(function(){
			loadMediaInformation();	
		});

		/**
		 * Will load the Movie from the API and populate the appropriate fields
		 */
		function loadMediaInformation(){
			$.ajax({
				type : "GET",
				url : "/api/metadata/movies/{{ $movie_id }}",
				dataType : "JSON",
				success : function(data)
				{
					var movie = data.data;

					$("#movie-title").html(movie.name);
					$("#movie-description").html(movie.description);
					$("#movie-level").html(movie.level);

					if(movie.image_path != null)
					{
						$("#movie-image").attr("src", movie.image_path);
					}

					showVideos(movie.videos);
				},
				error : function(data)
				{
					$(".container").hide();

					//show error here
					$(".error").show();

					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "@lang('index.layout.general.error')";
					}

					$("#movie-error").html(message);

				}
			});
		}

		/**
		 * Given a JSON value containing all the videos, it will populate the videos tables.
		 */
		function showVideos(videos)
		{
			var table_records = "";

			$.each(videos, function(index, value){
				if(value != null)
				{
					var array = JSON.parse(value.timestamps_json);
					$.each(array, function(i,v){
						table_records += "<tr>"
								+ "<td>" + (i+1) + "</td>"
								+ "<td>" + (v.to - v.from) +"s</td>"//end time - start time converted to time string
								+ "<td><a href='/video/play/" + value.id + "' class='btn btn-default glyphicon glyphicon-play-circle'></a></td>"//get duration
								+ "<td>" + getVideoScore(value) + "</td>"
								+ "</tr>";
					});
					
				}
			});

			//Add the cords to the video table
			$("#movie-videos").append(table_records);
		}
	</script>
@stop