@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
	<link rel="stylesheet" href="/css/video-script.css">

	<style>

		.video-controls
		{
			width: 100%;
			font-size: 30px;
		}

		.video-controls span, .video-controls div, .video-controls a
		{
			display: inline-block;
			color: #999;
		}

		.mute, .full-screen
		{
			float: right;
			padding-left: 20px;
			margin-right: 20px;
			color: #999;
		}

		.play-pause
		{
			margin-left: 20px;
		}

		.play-pause, .speed
		{
			padding-right: 20px;
			color: #999;
		}

		.glyphicon:hover
		{
			color: #555;
		}

	</style>
@stop

@section('content')
<div class="jumbotron" style="padding: 0; margin-bottom: 0;">	
	<div id="video-container">

		<video width="100%" id="video-player">
			<source src="../videos/TestVideo.mp4" type="video/mp4"/>
			Your browser does not support the video tag.
		</video>

		<div class="video-controls" style="width: 100%; font-size: 30px;">
		
			<a href="#" class="play-pause">
				<span class="glyphicon glyphicon-play"></span>
			</a>

			<a href="#" class="speed">
				<span class="glyphicon glyphicon-fast-forward"></span>
			</a>

			<div class="video-time">
				<span class="current">0:00</span>/<span class="duration">0:00</span>
			</div>

			<a href="#" class="full-screen">
				<span class="glyphicon glyphicon-fullscreen"></span>
			</a>

			<a href="#" class="mute">
				<span class="glyphicon glyphicon-volume-up"></span>
			</a>
		</div>

	</div>
</div>

<script>
	$( document ).ready( function() 
	{
		var videoPlayer = $('#video-player');
		
		$( '.play-pause' ).click( function()
		{
			if(videoPlayer.get(0).paused)
			{
				videoPlayer.get(0).play();

				$( '.glyphicon-play' ).attr( 'class', 'glyphicon glyphicon-pause' );
			}
			else
			{
				videoPlayer.get(0).pause();

				$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
			}

			return false;
		});

		videoPlayer.on('timeupdate', function()
		{			
			var seconds = Math.round(videoPlayer.get(0).currentTime);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.current').text(time);
		});

		videoPlayer.on('loadedmetadata', function()
		{
			var seconds = Math.round(videoPlayer.get(0).duration);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.duration').text(time);
		});

		videoPlayer.on('timeupdate', function()
		{		
			if(Math.round(videoPlayer.get(0).currentTime) == Math.round(videoPlayer.get(0).duration))
			{
				$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
			}
		});

		$( '.speed' ).click( function()
		{
			if(videoPlayer.get(0).playbackRate == 1)
			{
				videoPlayer.get(0).playbackRate += 0.5;

				$( '.glyphicon-fast-forward' ).attr( 'class', 'glyphicon glyphicon-step-forward' );
			}
			else
			{
				videoPlayer.get(0).playbackRate -= 0.5;

				$( '.glyphicon-step-forward' ).attr( 'class', 'glyphicon glyphicon-fast-forward' );
			}

			console.log(videoPlayer.get(0).playbackRate);
		});

		$( '.mute' ).click(function()
		{
			if( !videoPlayer.get(0).muted )
			{
				videoPlayer.get(0).muted = true;

				$('.glyphicon-volume-up').attr( 'class' , 'glyphicon glyphicon-volume-off');
			}
			else
			{
				videoPlayer.get(0).muted = false;

				$('.glyphicon-volume-off').attr( 'class' , 'glyphicon glyphicon-volume-up');
			}
		});

		$( '.full-screen' ).on( 'click', function()
		{
			videoPlayer.get(0).webkitEnterFullscreen();
			videoPlayer.get(0).mozRequestFullScreen();
			return false;
		});
	});

</script>
@stop
