@extends('master')

<head>

</head>

@section('content')
<div id="mainContainer">
	<div id="jp_container_1" class="jp-video">
		<div class="jp-title">
			<h1>Test Video Title</h1>
		</div>
		<div class="jp-type-single">
			<div id="jquery_jplayer_1" class="jp-jplayer"></div>
			<div class="jp-gui">
			<div class="jp-video-play">
				<a href="javascript:;" class="jp-video-play-icon" tabindex="1">&#61515;</a>
			</div>
			<div class="jp-interface">
				<div class="jp-controls-holder">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">&#61515;</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">&#61516;</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">&#61480;</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">&#61478;</a></li>
					</ul>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen"> &#61541;</a></li>
						<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen"> &#61542;</a></li>
					</ul>
				</div>
				
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time"></div>
			</div>
			</div>
			</div>
	</div>
	<div id="scriptLocation">
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

@stop