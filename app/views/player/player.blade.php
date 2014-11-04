@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/video-script.css">
@stop

@section('content')
	<div id="wrapper">
		<div class="error-message alert alert-danger" style="display:none; margin-top:25px;">
		</div>
		<!-- Player here -->
		<div id="player-container">
			<video width="100%" controls id="video-player" preload='none'>
				<source class="source" type="video/mp4">
				<p>Your browser does not support HTML5 video.</p>
			</video>
		</div>
		<div id="script">
		</div>
	</div>

	<script>
		function loadScript()
		{
			$.ajax({
				type: 'GET',
				url : '/content/scripts/{{ $video_id }}',
				success : function(data){
					$('#script').html(data.data[0].text);
					$('#script span[data-type=actor]:not(:first)').before('<br>');
				},
				error : function(data){
					var json = $.parseJSON(data);
					$('#script').html(json.data);	
				}
			});
		}

		function loadVideo() {
			var url = '/content/videos/{{ $video_id }}';
			$.ajax({
				type : 'GET',
				url : url,
				success : function(data){
					$('#video-player').find('source').attr('src', url);
					$('#video-player').load();
					loadScript();
				},
				error : function(data){
					var json = $.parseJSON(data.responseText);
					$('.error-message').html(json.data);
					$('.error-message').show();
				}
			});
		}

		$(function() {
			loadVideo();

			$('#script').on('mouseenter', 'span[data-type=word]', function() {
				$(this).addClass('word-hover');
			})
			.on('mouseleave', 'span[data-type=word]', function() {
				$(this).removeClass('word-hover');
			});

			$('#script').on('click', 'span[data-type=word]', function() {
				$(this).toggleClass('word-selected');
			});
		});
	</script>
@stop
