@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
	<link rel="stylesheet" href="/css/video-script.css">
	<link rel="stylesheet" href="/css/video-player.css">
@stop

@section('content')
<!-- Player here -->
<div class="jumbotron col-lg-6 col-md-6 col-xs-6" style="width: 50%;">	
	<script src="/js/video-player.js"></script>	
	<div id="video-container">
		<video width="100%" id="video-player">
			<source class="source" src="../videos/TestVideo.mp4" type="video/mp4">
			<p>@lang('player.player.error')</p>
		</video>

		<!--Player controls-->
		<div class="video-controls" style="width: 100%;">				
			<a href="#" class="play-pause col-xs-1 col-md-1 col-lg-1">
				<span class="glyphicon glyphicon-play"></span>
			</a>
			<!--
			<a href="#" class="speed col-xs-1 col-md-1 col-lg-1" data-toggle="tooltip" data-placement="bottom" data-original-title="Playing at 1x speed.">
				<span class="glyphicon glyphicon-fast-forward"></span>
			</a>-->

			<div class="dropdown speed-dropdown" data-toggle="tooltip" data-placement="top" data-original-title="Playing at 1x speed.">
				<button class="btn btn-default dropdown-toggle speed-dropdown" type="button" id="speed-drop" data-toggle="dropdown" aria-expanded="true">
				    <span class="glyphicon glyphicon-fast-forward"></span>
				    <span class="caret"></span>
			  	</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="speed-drop">
					<li role="presentation"><a class="speed faster" role="menuitem" tabindex="-1" href="#">Faster</a></li>
					<li role="presentation"><a class="speed normal" role="menuitem" tabindex="-1" href="#">Normal</a></li>
					<li role="presentation"><a class="speed slower" role="menuitem" tabindex="-1" href="#">Slower</a></li>
				</ul>
			</div>

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
