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

		.video-controls span, .video-controls div
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
			padding-right: 20px;
			margin-left: 20px;
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

		<video width="100%" poster="poster.jpg">
			<source type="video/youtube" src="http://www.youtube.com/watch?v=nOEw9iiopwI" />
			Your browser does not support the video tag.
		</video>

		<div class="video-controls" style="width: 100%; font-size: 30px;">
		
			<a href="#" class="play-pause">
				<span class="glyphicon glyphicon-play"></span>
			</a>

			<div class="video-time">
				<span class="current">0:00</span>/<span class="duration">0:00</span>
			</div>

			<a href="#" class="mute">
				<span class="glyphicon glyphicon-volume-up"></span>
			</a>

			<a href="#" class="full-screen">
				<span class="glyphicon glyphicon-fullscreen"></span>
			</a>
		</div>

	</div>
</div>

<script>
	$( document ).ready( function() 
	{
		var videoPlayer = $('#video-container');
		
		$( '.play-pause' ).click( function()
		{
			if(videoPlayer[0].paused)
			{
				videoPlayer[0].play();

				$( '.glyphicon-play' ).attr( 'class', 'glyphicon glyphicon-pause' );
			}
			else
			{
				videoPlayer[0].pause();

				$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
			}

			return false;
		});

		videoPlayer.on('timeupdate', function()
		{
			$('.current').text(Math.round(videoPlayer[0].currentTime));
		});

		videoPlayer.on('loadedmetadata', function()
		{
			$('.duration').text(Math.round(videoPlayer[0].duration));
		});

		$('.mute').click(function()
		{
			if( !videoPlayer[0].muted )
			{
				videoPlayer[0].muted = true;

				$('.glyphicon-volume-up').attr( 'class' , 'glyphicon glyphicon-volume-off');
			}
			else
			{
				videoPlayer[0].muted = false;

				$('.glyphicon-volume-off').attr( 'class' , 'glyphicon glyphicon-volume-up');
			}
		});

		$('.full-screen').on( 'click', function()
		{
			videoPlayer[0].webkitEnterFullscreen();
			videoPlayer[0].mozRequestFullScreen();
			return false;
		});
	});

</script>
@stop
