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

		.video-selection tbody tr {
			cursor: pointer;
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
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Part Number</th>
									<th>Viewed</th>
									<th>Length</th>
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
					loadVideos(commercial.videos);
				},
				error : function(data)
				{

				}
			});
		}

		//shows all the videos in the table.
		function loadVideos(videos)
		{
			var table_records = "";

			$.each(videos, function(index, value){
				if(value != null)
				{
					table_records += "<tr>"
								+ "<td>" + value.id + "</td>"
								+ "<td></td>"
								+ "<td></td>"
								+ "</tr>";
				}
			});

			//Add the cords to the video table
			$("#commerial-videos").append(table_records);
		}
	</script>
@stop