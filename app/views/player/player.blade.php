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
			<h3>Script goes here</h3>
			<p class="script">
				Mayowazu ni ima   mujun-darake no sekai o</br>
				Sono te de uchihanate</br></br>

				Koboreta namida no nukumori de</br>
				Yasashisa o shitta hazu na no ni</br>
				Doushite   mata kizutsukeatte</br>
				Nikushimi o umidashite ikun darou</br></br>

				Kishimu you na itami   shiita sono tsuyosa ga</br>
				Itsuka mirai o yasashiku tsutsumu no darou</br></br>

				Mayowazu ni ima   mujun-darake no sekai o</br>
				Sono te de uchihanate</br>
				Akai namida de oowareta kanashimi o</br>
				Sotto sotto dakishimete</br></br>

				Narihibiita shoudou ga hajimari no oto ni kawaru you ni</br>
		</p>
		</div>
	</div>
</div>

<script>  
	var url = "/content/videos/{{$video_id}}";
	$.ajax({
		type : "GET",
		url : url,
		success : function(data){
			$("#video-player").find("source").attr("src", url);
			$("#video-player").load();
		},
		error : function(data){
			var json = $.parseJSON(data.responseText);
			$(".error-message").html(json.data);
			$(".error-message").show();
		}
	});
</script>

@stop
