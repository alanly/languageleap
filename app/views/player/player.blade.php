@extends('master')



@section('css')
	<link rel="stylehseet" href="css/player.css">
@stop


@section('content')


<div class="container">
	<div class="row">
		<div class="error-message alert alert-danger" style="display:none; margin-top:25px;">
		</div>
		<div class="col-md-6">
			<!-- Player here -->
			<div class="player-container" style="padding-top:25px;">
				<video width="100%" controls id="video-player" preload='none'>
					<source class="source" type="video/mp4">
					<p>Your browser does not support HTML5 video.</p>
				</video>
			</div>
		</div>
		<div class="col-md-6">
			<p class="script">
					
			</p>
		</div>
	</div>
</div>

<script>  
	var url = "/content/videos/{{ $video_id }}";
	$.ajax({
		type : "GET",
		url : url,
		success : function(data){
			$("#video-player").find("source").attr("src", url);
			$("#video-player").load();
			getScript();
		},
		error : function(data){
			var json = $.parseJSON(data.responseText);
			$(".error-message").html(json.data);
			$(".error-message").show();
		}
	});

	function getScript()
	{
		$.ajax({
			type: "GET",
			url : "/content/scripts/{{ $video_id }}",
			success : function(data){
				$(".script").html(data.data[0].text);
			},
			error : function(data){
				var json = $.parseJSON(data);
				$(".script").html(json.data);	
			}

		});
	}
</script>

@stop
