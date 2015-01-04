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
		<video width="100%" id="video-player" preload="none">
			<source class="source" type="video/mp4">
			<p>@lang('player.player.error')</p>
		</video>

		<!--Player controls-->
		<div class="video-controls" style="width: 100%;">				
			<a href="#" class="play-pause col-xs-1 col-md-1 col-lg-1">
				<span class="glyphicon glyphicon-play"></span>
			</a>

			<a href="#" class="speed col-xs-1 col-md-1 col-lg-1">
				<span class="glyphicon glyphicon-fast-forward"></span>
			</a>

			<div class="video-time col-xs-3 col-md-3 col-lg-3">
				<span class="current">0:00</span>/<span class="duration">0:00</span>
			</div>
			
			<div id="slider" class="slider col-xs-5 col-md-5 col-lg-5">
				<input type="range" id="slider-bar" class="slider-width" value="0" min="0" max="100"/>
			</div>

			<a href="#" class="full-screen col-xs-1 col-md-1 col-lg-1">
				<span class="glyphicon glyphicon-fullscreen"></span>
			</a>

			<a href="#" class="mute col-xs-1 col-md-1 col-lg-1">
				<span class="glyphicon glyphicon-volume-up"></span>
			</a>
		</div>
	</div>			
</div>

@stop
