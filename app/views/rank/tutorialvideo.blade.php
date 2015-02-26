@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/video-player.css">
@stop


@section('javascript')
	<script src="/js/video-player.js"></script>	
@stop

@section('content')

<div class="title">
	<h1>@lang('rank.title')</h1>
</div>
<div class="jumbotron" style="padding-left: 20px; margin-bottom: 0;">	
	<!-- Player here -->
	<div class="jumbotron col-lg-6 col-md-6 col-xs-6" style="width: 50%;">	
		<div id="video-container">
			<video width="100%" id="video-player">
				<source class="source" type="video/mp4" src="/videos/TestVideo.mp4">
				<p>@lang('player.player.error')</p>
			</video>

			<!--Player controls-->
			<div class="video-controls" style="width: 100%;">				
				<a href="#" class="play-pause col-xs-1 col-md-1 col-lg-1">
					<span class="glyphicon glyphicon-play"></span>
				</a>
				
				<div class="dropdown speed-dropdown" data-toggle="tooltip" data-placement="top" data-original-title="Playing at 1x speed.">
					<button class="btn btn-default dropdown-toggle speed-dropdown" type="button" id="speed-drop" data-toggle="dropdown" aria-expanded="true">
					    <span class="glyphicon glyphicon-fast-forward"></span>
					    <span class="caret"></span>
				  	</button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="speed-drop">
						<li role="presentation"><a class="speed faster" role="menuitem" tabindex="-1" href="#">@lang('rank.player.faster')</a></li>
						<li role="presentation"><a class="speed normal" role="menuitem" tabindex="-1" href="#">@lang('rank.player.normal')</a></li>
						<li role="presentation"><a class="speed slower" role="menuitem" tabindex="-1" href="#">@lang('rank.player.slower')</a></li>
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
		<audio id="word-audio" autoplay>
			<p>@lang('player.audio.error')</p>
		</audio>
	</div>
</div>
<div class="form-group">
	<div id="quizButton">
		<a class="btn btn-primary" href="{{ URL::to('/rank') }}">@lang('rank.proceed')</a>
	</div>
</div>
@stop
