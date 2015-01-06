@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
	<link rel="stylesheet" href="/css/video-script.css">
	<link rel="stylesheet" href="/css/video-player.css">
@stop

@section('content')
	<div id="wrapper">
		<div class="error-message alert alert-danger" style="display:none">
		</div>

		<div class="row">
			<div id="script" class="col-lg-6 col-md-6 col-xs-6" style="width: 50%;">
			</div>

			<!-- Player here -->
			<div class="jumbotron col-lg-6 col-md-6 col-xs-6" style="width: 50%;">	
				<script src="/js/video-player.js"></script>	
				<div id="video-container">
					<video width="100%" id="video-player">
						<source class="source" type="video/mp4">
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


		<audio id="word-audio" autoplay>
			<p>@lang('player.audio.error')</p>
		</audio>

		<a class="continue btn btn-success">@lang('player.script.quiz')</a>
		<a class="define btn btn-primary">@lang('player.script.flashcard')</a>
		<button id="mute-audio" class="pronunciations-on" title="Audio hover"></button>
	</div>

	<div class="clear" style="clear:both;"></div>
	
	<div id="flashcard" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					@include('flashcard')
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
					addNonDefinedTags();
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
			loadScript();
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

			$('#script span[data-type=nonDefinedWord]').each(function() {
				$(this).tooltip({
						'container': '#script',
						'placement': 'auto top',
						'title': 'Loading definition...'
				});
			});
		}

		function loadCarouselItems()
		{
			var carouselItems = '';
			$('#script .word-selected').each(function(i)
			{
				carouselItems += '<div class="item' + ((i == 0) ? ' active' : '') + '">' +
								'<h3>' + $(this).text() + '<br>' +
								'<small>' + $(this).data('pronunciation') + '</small></h3><br>' +
								'<span>' + $(this).data('full-definition') + '</span>' +
								'</div>';
			});

			$("#flashcard .carousel-inner").html(carouselItems);
		}

		function loadUndefinedSelectedWords()
		{
			var deffereds = [];

			$('#script .word-selected[data-type=nonDefinedWord]').each(function()
			{
				deffereds.push(loadDefinition($(this)));
			});

			return deffereds;
		}

		function loadFlashcards()
		{
			// Check if any words have been selected
			if ($('#script .word-selected').length == 0)
				return;

			$('#flashcard').modal();
			$('#flashcard .loading').show();

			$.when.apply(null, loadUndefinedSelectedWords()).done(function()
			{
				$('#flashcard .loading').hide();
				loadCarouselItems();

				// This makes the carousel work for dynamically loaded content
				$('#scroller').carousel("pause").removeData()
			});
			
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

		function addNonDefinedTags()
		{
			var wordsToDefine = formatNonDefinedWords();
			var wordsArray = wordsToDefine.split(' ');
			var uniqueWords = removeDuplicateWords(wordsArray);

			addTags(uniqueWords);
		}

		function addTags(words)
		{
			var scriptHtml = $("#script").html();

			for(var i = 0; i < words.length; i++)
			{
				//Regex test: https://www.regex101.com/r/mG8jG5/6
				var regex = new RegExp('(\\b(' + words[i] + ')\\b)(?![^<]*>|[^<>]*<\\s*\\/)', 'ig');
				scriptHtml = scriptHtml.replace(regex, "<span data-type='nonDefinedWord' name='" + words[i].toLowerCase() + "Word'>" + words[i] + "</span>");
			}

			$("#script").html(scriptHtml);
		}

		function formatNonDefinedWords()
		{
			var nonDefinedWords = getTextBetweenSpans(); //Get all the text between the span tags of defined words
			var noPunctuation = removePunctuation(nonDefinedWords); //Remove all ',' and '.' in the string
			var noDoubleSpaces = removeDoubleSpaces(noPunctuation); //Replace any number of spaces greater than 1, with 1 space
			var trimmedText = noDoubleSpaces.trim();

			return trimmedText;
		}

		function removeDuplicateWords(words)
		{
			var b = {}; //Create a dictionary and add all the words as keys. Keys are unique so no duplicates
			for (var i = 0; i < words.length; i++) 
			{ 
				b[words[i].toUpperCase()]=words[i];
			}

			var c = []; //Push the keys into an array
			for (var key in b) 
			{ 
				c.push(b[key]); 
			}

			return c;
		}

		function getTextBetweenSpans()
		{
			var text = $('#script')
						.clone()	//clone the element
						.children()	//select all the children
						.remove()	//remove all the children
						.end()		//again go back to selected element
						.text();

			return text;
		}

		function removePunctuation(text)
		{
			return text.replace(/\./g, "").replace(/,/g, "");
		}

		function removeDoubleSpaces(text)
		{
			return text.replace(/\n/, "").replace(/\s{2,}/, " ");
		}

		function loadDefinition($word)
		{
			var url = '/api/dictionaryDefinitions/';

			return $.ajax({
				type: 'GET',
				url: url,
				data: { word: $word.text().trim(), video_id : "{{ $video_id }}" },
				success : function(data)
				{
					// For each of the same word
					$('#script [name=' + $word.attr('name') + ']').each(function()
					{
						$(this).data('full-definition', data.data.definition);
						$(this).data('pronunciation', data.data.pronunciation);
						setTooltipDefinition($(this), data.data.definition);
						setWordAudioUrl($(this), data.data.audio_url);
					});
					
					// Only play the audio clip if the mouse is still over the word
					if ($($word[0]).is(':hover'))
						setCurrentAudio(data.data.audio_url);
				},
				error : function(data)
				{
					setTooltipDefinition($word, "Definition not found.");
				}
			});
		}

		function setTooltipDefinition($word, definition)
		{
			$word.attr('data-original-title', definition)
			.tooltip('fixTitle');

			$word.attr('data-type', 'definedWord');

			// Only show the tooltip if the mouse is still hovering over the word
			if ($($word[0]).is(':hover'))
				$word.tooltip('show');
		}

		function setWordAudioUrl($word, url)
		{
			$('[name="' + $word.text().trim().toLowerCase() + 'Word"]').each(function() {
				$(this).data('audio_url', url);
			});
		}

		function setCurrentAudio(url)
		{
			$('#word-audio').attr('src', url);
		}

		function getMinutesFromTimestamp(timestamp)
		{
			return parseInt(timestamp.split(':')[0]);
		}

		function getSecondsFromTimestamp(timestamp)
		{
			return parseInt(timestamp.split(':')[1]);
		}

		function getTimeInSecondsFromTimestamp(timestamp)
		{
			return (getMinutesFromTimestamp(timestamp) * 60) + getSecondsFromTimestamp(timestamp);
		}

		function updateCurrentSpeaker()
		{
			var currentTimeInSeconds = Math.floor(this.currentTime);
			var $speakers = $('#script span[data-timestamp]');

			if ($speakers.length > 0)
			{
				var $currentSpeaker = $speakers.eq(0);

				var timestamp = $currentSpeaker.data('timestamp');
				var smallestDifference = currentTimeInSeconds - getTimeInSecondsFromTimestamp(timestamp);

				// Find the speaker that produces the smallest positive difference
				$speakers.each(function()
				{
					timestamp = $(this).data('timestamp');
					var tempDifference = currentTimeInSeconds - getTimeInSecondsFromTimestamp(timestamp);
					
					if (tempDifference < smallestDifference &&
						tempDifference >= 0)
					{
						$currentSpeaker = $(this);
						smallestDifference = tempDifference;
					}
				});

				$speakers.removeClass('currently-speaking');
				$currentSpeaker.addClass('currently-speaking');
			}
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

			// Used to determine how long the mouse is hovered over a word
			var hoverTimer;

			$('#script')
				.on('mouseenter', 'span[data-type=word]', function()
				{
					$(this).addClass('word-hover');
				})
				.on('mouseleave', 'span[data-type=word]', function()
				{
					$(this).removeClass('word-hover');
				})
				.on('mouseenter', 'span[data-type=nonDefinedWord]', function()
				{
					var $this = $(this);
					$this.addClass('word-hover');
					hoverTimer = setTimeout(function() { loadDefinition($this); }, 500);
				})
				.on('mouseleave', 'span[data-type=nonDefinedWord]', function()
				{
					$(this).removeClass('word-hover');
					clearTimeout(hoverTimer);
				}).on('mouseenter', 'span[data-type=definedWord]', function()
				{
					$(this).addClass('word-hover');
					setCurrentAudio($(this).data('audio_url'));
				})
				.on('mouseleave', 'span[data-type=definedWord]', function()
				{
					$(this).removeClass('word-hover');
				});

			$('#script').on('click', 'span[data-type!=actor]', function()
			{
				$(this).toggleClass('word-selected');
			});

			$('#video-player').bind('timeupdate', updateCurrentSpeaker);

			$('#mute-audio').on('click', function()
			{
				$(this).toggleClass('pronunciations-off');
				$(this).toggleClass('pronunciations-on');
				
				var $audio = $('#word-audio');
				$audio.prop('muted', !$audio.prop('muted'));
			});
		});
	</script>
@stop
