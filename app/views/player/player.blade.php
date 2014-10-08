@extends('master')

<head>

</head>

@section('content')
<div id="mainContainer">
	<div class="videoTitle">
		<h1>Test Video Title</h1>
	</div>
	
	<div class="playerHolder">
		<div id="jq_jp_1" class="videoPlayer"></div>
		<div class="gui">
			<div class="playIconHolder">
				<a href="javascript:;" class="playIcon" tabindex="1">&#61515;</a>
			</div>
			<div class="playerUI">
				<div class="controlsHolder">
					<ul class="playerControls">
						<li><a href="javascript:;" class="playerPlay" tabindex="1">&#61515;</a></li>
						<li><a href="javascript:;" class="playerPause" tabindex="1">&#61516;</a></li>
					</ul>
					<div class="volumeBarHolder">
						<div class="volumeBarValue"></div>
					</div>
				</div>
				
				<div class="progressHolder">
					<div class="seekBar">
						<div class="progressBar"></div>
					</div>
				</div>
				
				<div class="timeHolder"></div>
			</div>
		</div>
	</div>
		
</div>

@stop