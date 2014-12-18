@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
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
				<p>{{ trans('player.player.error') }}</p>
			</video>
		</div>

		<div id="script">
		</div>

		<a class="continue btn btn-success">{{ trans('player.script.quiz') }}</a>
		<a class="define btn btn-primary">{{ trans('player.script.flashcard') }}</a>
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
	</script>
@stop
