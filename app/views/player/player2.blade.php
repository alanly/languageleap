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

		<video width="100%" id="video-player" autoplay>
			<source src="../videos/TestVideo.mp4" type="video/mp4"/>
			Your browser does not support the video tag.
		</video>

		<div class="video-controls" style="width: 100%; font-size: 30px;">
		
			<a href="#" class="play-pause">
				<span class="glyphicon glyphicon-play"></span>
			</a>

			<div class="video-time">
				<span class="current">0:00</span>/<span class="duration">0:00</span>
			</div>
<!--
			<div class="col-lg-6 col-sm-6">
	            <div id="v-slider" style="height:200px;" class="ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
	            	<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="height: 69%;">
	            	</div>
	            	<a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="bottom: 69%;">	
	            	</a>
	            </div>
	        </div>
-->
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
			$('.current').text(Math.round(videoPlayer.get(0).currentTime));
		});

		videoPlayer.on('loadedmetadata', function()
		{
			$('.duration').text(Math.round(videoPlayer.get(0).duration));
		});

		$('.mute').click(function()
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

		$('.full-screen').on( 'click', function()
		{
			videoPlayer.get(0).webkitEnterFullscreen();
			videoPlayer.get(0).mozRequestFullScreen();
			return false;
		});
	});

</script>
@stop
