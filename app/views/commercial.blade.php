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
	</style>
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
					<h3>Difficulty Level</h3>
					<p id="commercial-level"></p>
				</span>
				<span class="description">
					<h3>Description</h3>
					<p id="commercial-description"></p>
				</span>
				<br>
				<span class="video-selection">
					<div class="panel panel-default">
						<!-- Table -->
						<table class="table">
							<thead>
								<tr>
									<th>Part Number</th>
									<th>Length</th>
									<th>Play</th>
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
						message = "There was a problem loading the information, Please try again at a later time.";
					}

					$("#commercial-error").html(message);

				}
			});
		}

		//shows all the videos in the table.
		function showVideos(videos)
		{
			var table_records = "";

			$.each(videos, function(index, value){
				if(value != null)
				{
					table_records += "<tr>"
								+ "<td>" + value.id + "</td>"
								+ "<td></td>"//viewed or not
								+ "<td><a href='/video/play/" + value.id + "' class='btn btn-default glyphicon glyphicon-play-circle'></a></td>"//get duration
								+ "</tr>";
				}
			});

			//Add the cords to the video table
			$("#commerial-videos").append(table_records);
		}
	</script>
@stop