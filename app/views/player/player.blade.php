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

		.progress
		{
			margin-left: 50px;
			margin-right: 50px;
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
	<div id="wrapper">
		<div class="error-message alert alert-danger" style="display:none; margin-top:25px;">
		</div>

		<!-- Player here -->
		<div class="jumbotron" style="padding: 0; margin-bottom: 0;">	
			<div id="video-container">

				<video width="100%" id="video-player" preload='none' width="100%">
					<source class="source" src="../videos/TestVideo.mp4" type="video/mp4"/>
					Your browser does not support the video tag.
				</video>

				<!--Player controls-->
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

			<div class="progress">
				<div class="progress-bar" style="width: 0%;">
				</div>
			</div>
		</div>

		<div>
			<div id="script">
			</div>

			<a class="continue btn btn-success">Continue to Quiz</a>
			<a class="define btn btn-primary">Define Selected</a>
		</div>
	</div>

	<div class="clear" style="clear:both;"></div>
	
	<div id="flashcard" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
		
	<script>
		var definitions = [];
		
		function loadScript()
		{
			$.ajax({
				type: 'GET',
				url : '/content/scripts/{{ $video_id }}',
				success : function(data){
					$('#script').html(data.data[0].text);
					$('#script br').remove();
					$('#script span[data-type=actor]:not(:first)').before('<br>');

					loadScriptDefinitions();
				},
				error : function(data){
					var json = $.parseJSON(data);
					$('#script').html(json.data);	
				}
			});
		}

		function loadVideo()
		{
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

		// Later on, this will be used for flashcards
		function loadScriptDefinitions() {
			$('#script span[data-type=word]').each(function() {
				var $this = $(this);
				var definitionId = $this.data('id');

				if (definitionId == undefined)
					return;

				$.getJSON('/api/metadata/definitions/' + definitionId, function(data) {
					if (data.status == 'success') {
						$this.tooltip({
							'container': '#script',
							'placement': 'auto top',
							'title': data.data.definition
						});

						$this.data('definition', data.data.definition);
						$this.data('full-definition', data.data.full_definition);
						$this.data('pronunciation', data.data.pronunciation);
					} else {
						// Handle failure
					}
				});
			});
		}

		function loadDefinitions()
		{
			definitions = [];
			$('#script span[data-type=word]').each(function(index) {
				var def_id = $(this).data("id");
				if(def_id != null && $(this).hasClass("word-selected")){
					var key = "word" + index;
					//definitions.push({ key :  def_id });
					definitions.push(def_id);
				}
			});
		}

		function loadFlashcards()
		{
			loadDefinitions();
			if(definitions.length > 0){
				$("#flashcard .modal-body").load('/flashcard', { definitions : definitions }, function(data){
					$('#flashcard').modal();
				});
			}
		}

		function loadQuiz() {
			var $selectedWords = $('#script .word-selected');

			if ($selectedWords.length > 0) {
				// This data needs to be sent to the quiz page
				var json = {
					'video_id': {{ $video_id }},
					'selected_words': $selectedWords.map(function() { return $(this).data('id'); }).get(),
					'all_words': $('#script span[data-type=word]').map(function() { return $(this).data('id'); }).get()
				};

				// Store data in the HTML5 Storage schema
				localStorage.setItem("quizPrerequisites", JSON.stringify(json));
			}

			window.location = '/quiz';
		}

		$(function()
		{
			loadVideo();

			$(".define").click(function()
			{
				loadFlashcards();
			});

			$('.continue').click(function()
			{
				loadQuiz();
			});

			$('#script')
				.on('mouseenter', 'span[data-type=word]', function()
				{
					$(this).addClass('word-hover');
				})
				.on('mouseleave', 'span[data-type=word]', function()
				{
					$(this).removeClass('word-hover');
				});

			$('#script').on('click', 'span[data-type=word]', function()
			{
				$(this).toggleClass('word-selected');
			});
		});

	//Player Controls
	$( document ).ready( function() 
	{
		var videoPlayer = $('#video-player');
		
		//Play/Pause video and toggle glyph icon 
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

		//Update current time of the video
		videoPlayer.on('timeupdate', function()
		{			
			var seconds = Math.round(videoPlayer.get(0).currentTime);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.current').text(time);
		});

		//Update total time of the video
		videoPlayer.on('loadedmetadata', function()
		{
			var seconds = Math.round(videoPlayer.get(0).duration);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.duration').text(time);
		});

		//Update Play-Pause glyph icon when video ends
		videoPlayer.on('timeupdate', function()
		{		
			if(Math.round(videoPlayer.get(0).currentTime) == Math.round(videoPlayer.get(0).duration))
			{
				$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
			}
		});

		//Update video progress bar
		videoPlayer.on('timeupdate', function()
		{
			var progressBar = $( '.progress-bar' );

			var completionPercent = Math.floor(($( '.progress' ).width() / videoPlayer.get(0).duration) * videoPlayer.get(0).currentTime);

			progressBar.width(completionPercent);
			console.log(progressBar[0].style.width);
		});

		//Toggle video speed and associated glyph icon
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
		});

		//Toggle Mute and associated glyph icon (no volume slider yet)
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

		//Full screen mode
		$( '.full-screen' ).on( 'click', function()
		{
			videoPlayer.get(0).webkitEnterFullscreen();
			videoPlayer.get(0).mozRequestFullScreen();
			return false;
		});
	});
	</script>
@stop
