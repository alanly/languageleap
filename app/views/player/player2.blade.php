@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
	<link rel="stylesheet" href="/css/video-script.css">
	<link rel="stylesheet" href="/css/video-player.css">
@stop

@section('content')
<div class="jumbotron" style="padding: 0; margin-bottom: 0;">
	<script src="/js/video-player.js"></script>	
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
			
			<div id="slider" class="slider">
				<input type="range" id="slider-bar" value="0" min="0" max="100"/>
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

@stop
