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
		<h2 id="episode-title"></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img id="episode-image" src="http://placehold.it/225x300" />
				</div>
			</div>
			<div class="col-md-9">
				<span class="level">
					<h3>@lang('index.layout.general.difficulty')</h3>
					<p id="episode-level"></p>
				</span>
				<span class="description">
					<h3>@lang('index.layout.general.description')</h3>
					<p id="episode-description"></p>
				</span>
				<br>
				<span class="video-selection">
					<div class="panel panel-default">
						<!-- Table -->
						<table class="table">
							<thead>
								<tr>
									<th>@lang('index.layout.general.part_number')</th>
									<th>@lang('index.layout.general.length')</th>
									<th>@lang('index.layout.general.play')</th>
									<th>@lang('index.layout.general.score')</th>
								</tr>
							</thead>
							<tbody id="episode-videos">
							</tbody>	
						</table>
					</div>
				</span>
			</div>
		</div>
	</div>

	<div class="error" style="display:none;">
		<div class="alert alert-danger" role="alert" id="episode-error">
			
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			loadEpisode();
		});

		/**
		 * Will load the episodes from the API and populate the appropriate fields
		 */
		function loadEpisode()
		{
			$.ajax({
				type : "GET",
				url : "/api/metadata/episode/{{ $episode_id }}",
				dataType : "JSON",
				success : function(data)
				{
					var episode = data.data.episode;


					$("#episode-title").html(episode.name + "<br> <small><em>Season " + episode.season_number + ", Episode " + episode.number + "</em></small>");
					$("#episode-description").html(episode.description);
					$("#episode-level").html(episode.level);

					if(episode.image_path != null)
					{
						$("#episode-image").attr("src", episode.image_path);
					}

					showVideos(data.data.videos);
				},
				error: function(data)
				{
					$(".container").hide();

					//show error here
					$(".error").show();

					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "@lang('index.layout.general.error')";
					}

					$("#episode-error").html(message);
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
					table_records += "<tr>"
									+ "<td>" + value.id + "</td>"
									+ "<td></td>"//end time - start time converted to time string
									+ "<td><a href='/video/play/" + value.id + "' class='btn btn-default glyphicon glyphicon-play-circle'></a></td>"//get duration
									+ "<td>" + getVideoScore(value) + "</td>"
									+ "</tr>";
				}
			});

			//Add the cords to the video table
			$("#episode-videos").append(table_records);
		}
	</script>
@stop