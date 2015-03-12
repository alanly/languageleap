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
		<h2 id="commercial-title"></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img id="commercial-image" src="http://placehold.it/225x300" />
				</div>
			</div>
			<div class="col-md-9">
				<span class="level">
					<h3>@lang('index.layout.general.difficulty')</h3>
					<p id="commercial-level"></p>
				</span>
				<span class="description">
					<h3>@lang('index.layout.general.description')</h3>
					<p id="commercial-description"></p>
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
							<tbody id="commerial-videos">
							</tbody>	
						</table>
					</div>
				</span>
			</div>
		</div>
	</div>

	<div class="error" style="display:none;">
		<div class="alert alert-danger" role="alert" id="commercial-error">
			
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			loadMediaInformation();	
		});

		/**
		 * Will load the media from the API and populate the appropriate fields
		 */
		function loadMediaInformation(){
			$.ajax({
				type : "GET",
				url : "/api/metadata/commercials/{{ $commercial_id }}",
				dataType : "JSON",
				success : function(data)
				{
					var commercial = data.data;

					$("#commercial-title").html(commercial.name);
					$("#commercial-description").html(commercial.description);
					$("#commercial-level").html(commercial.level);

					if(commercial.image_path != null)
					{
						$("#commercial-image").attr("src", commercial.image_path);
					}

					showVideos(commercial.videos);
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

					$("#commercial-error").html(message);

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
								+ "<td></td>" //end time - start time converted to time string
								+ "<td><a href='/video/play/" + value.id + "' class='btn btn-default glyphicon glyphicon-play-circle'></a></td>" //get duration
								+ "<td>" + getVideoScore(value) + "</td>"
								+ "</tr>";
				}
			});

			//Add the cords to the video table
			$("#commerial-videos").append(table_records);
		}
	</script>
@stop