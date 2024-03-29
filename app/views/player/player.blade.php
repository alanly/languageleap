@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/flashcard.css">
	<link rel="stylesheet" href="/css/video-script.css">
	<link rel="stylesheet" href="/css/video-player.css">
@stop

@section('javascript')
	<script src="/js/video-player.js"></script>	
@stop

@section('content')
	<div class="container">
		<div class="error-message alert alert-danger" style="display:none">
		</div>

		<div class="row">
			<!-- Player here -->
			<div class="col-lg-7 col-md-7 col-xl-12">	
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
								<li role="presentation"><a class="speed faster" role="menuitem" tabindex="-1" href="#">@lang('player.functions.faster')</a></li>
								<li role="presentation"><a class="speed normal" role="menuitem" tabindex="-1" href="#">@lang('player.functions.normal')</a></li>
								<li role="presentation"><a class="speed slower" role="menuitem" tabindex="-1" href="#">@lang('player.functions.slower')</a></li>
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

			<div id="script" class="col-lg-5 col-md-5 col-xs-12">
			</div>
			<audio id="word-audio" autoplay>
				<p>@lang('player.audio.error')</p>
			</audio>

			<a class="continue btn btn-success">@lang('player.script.quiz')</a>
			<a class="define btn btn-primary">@lang('player.script.flashcard')</a>
			
			<div id="load-quiz-error" class="alert alert-danger col-lg-6 col-md-6 col-xs-6" role="alert" style="margin-top:10px" hidden="hidden">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">@lang('player.error')</span>
				<span id="load-quiz-message"></span>
			</div>
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
	</div>
	<script>
		function initTooltips()
		{
			$('#script span[data-type!=actor]').each(function() {
				$(this).tooltip({
						'container': '#script',
						'placement': 'auto top',
						'title': 'Loading synonym...'
				});
			});
		}

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
					initTooltips();
				},
				error : function(data){
					var json = $.parseJSON(data);
					$('#script').html(json.data);	
				}
			});
		}

		function loadVideo()
		{
			// Combulate our source URL.
			var url = '/content/videos/{{ $video_id }}';
			// Get our player element.
			var $player = $('#video-player');
			// Get our 'source' element.
			var $source = $('#video-player').find('source');
			// Create an event handler callback for error on our player.
			$source.on('error', function(event)
			{
				$('.error-message').html('<p>@lang("player.load.error")</p>');
				$('.error-message').show();
			});
			// Set the desired source.
			$source.attr('src', url);
			// Load the source.
			$player.load();
			// Load the associated script.
			loadScript();
		}
		
		function playAudio(audioArray){
			var current = 0;
			
			setCurrentAudio(audioArray[current]);
			$('#word-audio').bind('ended', function(e){
				current++;
				if (current < audioArray.length) {
					setCurrentAudio(audioArray[current]);
				}
			});
		}

		function loadCarouselItems()
		{
			var carouselItems = '';
			$('#script .word-selected').each(function(i)
			{
				var audioAttribute = '';
				// Determine whether audio is available for the current word(s)
				if ($(this).data('type') == 'word') {
					audioAttribute = 'disabled';
					var audioUrl = '';

					$.each($(this).children(), function()
					{
						if ($(this).data('audio-url'))
							audioUrl += $(this).data('audio-url') + ' ';
					});

					if (audioUrl != '')
						audioAttribute = 'data-audio-url="' + audioUrl + '"';
				} else {
					audioAttribute = ($(this).data('audio-url')) ? ('data-audio-url="' + $(this).data('audio-url') + '"') : 'disabled';
				}

				var notAvailable =  (audioAttribute == 'disabled') ? ' not-available" title="Not available' : '';
				
				carouselItems += '<div class="item' + ((i == 0) ? ' active' : '') + '">' +
								'<h3>' + $(this).text() + '<br>' +
								'<small>' + (($(this).data('pronunciation') == null) ? 'Pronunciation not found' : $(this).data('pronunciation')) +
								'<button class="play-pronunciation glyphicon glyphicon-volume-up' + notAvailable + '" ' + audioAttribute +
								'></button></small></h3>' +
								'<br>' +
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
				deffereds.push(loadDictionaryDefinition($(this), initNonDefinedWordData));
			});
			return deffereds;
		}

		function loadAdminDefinedSelectedWords()
		{
			var deffereds = [];
			$('#script .word-selected[data-type=word]').each(function()
			{
				var $this = $(this);

				// Check if the audio has already been loaded before
				if ($this.children().length == 0) {
					var words = $this.text().split(' ');
					$($this).empty();

					$.each(words, function(i, v) {
						$($this).append($('<span>').text(v + ((i == words.length - 1) ? '' : ' ')));
					});
				}

				// For each word, load its audio
				$.each($($this).find('span'), function()
				{
					deffereds.push(loadDictionaryDefinition($(this), initAdminWordAudioData));
				});

				// Check if the definition has already been loaded
				if (!$this.data('definition'))
					deffereds.push(loadAdminDefinition($this));
			});
			return deffereds;
		}

		function loadFlashcards()
		{
			// Check if any words have been selected
			if ($('#script .word-selected').length == 0)
				return;

			// Clear existing carousel items
			$("#flashcard .carousel-inner").html('');
			$('#flashcard').modal();
			$('#flashcard .loading').show();

			// When all ajax calls are done, execute the anonymous callback function
			$.when.apply($, loadAdminDefinedSelectedWords().concat(loadUndefinedSelectedWords())).done(function()
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
			
				$(".continue").css('background', '#47a447 url(/img/misc/loading.gif) no-repeat center');
				$(".continue").attr('disabled', 'disabled');
				
				// This data needs to be sent to the quiz page
				var json = {
					'selected_words': $selectedWords.map(function() { 
						var word = $(this). text();
						var def = $(this).attr('data-type') == 'word' ? $(this).tooltip().data().fullDefinition : null;
						
						var node = $(this);
						var sentence = [];
						
						// Traverse to the beginning of the sentence
						while(node.prev().length > 0 && node.prev().attr("data-type") != "actor")
						{
							node = node.prev();
						}
						
						// Traverse to the end of the actor's line and build the sentence
						do
						{
							sentence.push(node.text());
							node = node.next();
						}while(node.length > 0 && node.next().attr("data-type") != "actor");
						
						sentence = sentence.join(' ');
						sentence += '.';
						
						return {'word':word, 'definition':def, 'sentence':sentence};
						
					}).get(),
					'video_id': {{ $video_id }}
				};
				$.ajax({
					url: '/api/quiz/video',
					type: 'POST',
					data: json,
					success: function (data) {
						// Store data in the HTML5 Storage schema
						localStorage.setItem("quizPrerequisites", JSON.stringify({'quiz_id': data.data.quiz_id}));
						localStorage.setItem("redirect", JSON.stringify({'redirect': data.data.redirect}));
						
						window.location = '/quiz';
					},
					error: function (jqXHR, textStatus, errorThrown) {
						
						$("#load-quiz-error").removeAttr("hidden");
						
						if(jqXHR.responseJSON != null)
						{
							$("#load-quiz-message").text(jqXHR.responseJSON.data);
						}
						else
						{
							$("#load-quiz-message").text(jqXHR.responseText);
						}
						// Re-enable button
						$(".continue").css('background', '');
						$(".continue").removeAttr('disabled');
					}
				});
			}
			else {
				
				$("#load-quiz-error").removeAttr("hidden");
				$("#load-quiz-message").text("@lang('player.quiz.select_words')");
			}
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
			return text.replace(/\./g, "").replace(/,/g, "").replace(/:/g, '').replace(/\(|\)|\[|\]/g, '');
		}

		function removeDoubleSpaces(text)
		{
			return text.replace(/\n/g, " ").replace(/\s{2,}/g, " ");
		}
		
		function loadAdminDefinition($word)
		{
			var definitionId = $word.data('id');
			if (definitionId == undefined)
				return;
			var url = '/api/metadata/definitions/' + definitionId;
			return $.ajax({
				type: 'GET',
				url: url,
				success : function(data)
				{
					$word.data('definition', data.data.definition);
					$word.data('full-definition', data.data.full_definition);
					$word.data('pronunciation', data.data.pronunciation);
					setTooltipSynonym($word, ((data.data.synonym) ? data.data.synonym : '@lang("player.quiz.synonym_not_found")'));
				},
				error : function(data)
				{
					setTooltipSynonym($word, "@lang('player.quiz.synonym_not_found')");
				}
			});
		}

		function loadDictionaryDefinition($word, callback)
		{
			var url = '/api/dictionaryDefinitions/';
			return $.ajax({
				type: 'GET',
				url: url,
				data: { word: $word.text().trim(), video_id : "{{ $video_id }}" },
				success : function(data)
				{
					callback($word, data);
				},
				error : function(data)
				{
					callback($word)
				}
			});
		}

		function initNonDefinedWordData($word, data)
		{
			// For each of the same word
			$('#script [name=' + $word.attr('name') + ']').each(function()
			{
				if (data && data.status == 'success') {
					$(this).data('full-definition', data.data.definition);
					$(this).data('pronunciation', data.data.pronunciation);
					setTooltipSynonym($(this), ((data.data.synonym) ? data.data.synonym : '@lang("player.quiz.synonym_not_found")'));
					setWordAudioUrl($(this), data.data.audio_url);
				} else {
					setTooltipSynonym($word, '@lang("player.quiz.synonym_not_found")');
				}
			});
		}

		function initAdminWordAudioData($word, data)
		{
			if (data && data.status == 'success') {
				$word.data('audio-url', data.data.audio_url);
			}
		}

		function setTooltipSynonym($word, synonym)
		{
			$word.attr('data-original-title', synonym)
			.tooltip('fixTitle');
			// Only show the tooltip if the mouse is still hovering over the word
			if ($($word[0]).is(':hover'))
				$word.tooltip('show');
		}

		function setWordAudioUrl($word, url)
		{
			$('[name="' + $word.text().trim().toLowerCase() + 'Word"]').each(function() {
				$(this).data('audio-url', url);
			});
		}

		function setCurrentAudio(url)
		{
			$('#word-audio').attr('src', url);
		}

		function getHoursFromTimestamp(timestamp)
		{
			return parseInt(timestamp.split(':')[0]);
		}

		function getMinutesFromTimestamp(timestamp)
		{
			return parseInt(timestamp.split(':')[1]);
		}

		function getSecondsFromTimestamp(timestamp)
		{
			return parseInt(timestamp.split(':')[2]);
		}

		function getTimeInSecondsFromTimestamp(timestamp)
		{
			return	getHoursFromTimestamp(timestamp) * 3600 +
					getMinutesFromTimestamp(timestamp) * 60 +
					getSecondsFromTimestamp(timestamp);
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

		function videoLoaded()
		{
			var $videoPlayer = $('#video-player');
			
			$videoPlayer[0].currentTime = ($videoPlayer.data('history-time')) ? $videoPlayer.data('history-time') : 0;
		}

		function loadVideoHistory()
		{
			var url = '/api/history/';
			$.ajax({
				type: 'GET',
				url: url,
				data: { video_id : "{{ $video_id }}" },
				success : function(data)
				{
					$('#video-player').data('history-time', data.data.current_time);
				},
				error : function(data)
				{
					$('#video-player').data('history-time', 0);
				}
			});
		}

		function saveVideoHistory()
		{
			var url = '/api/history/';
			$.ajax({
				async: false,
				type: 'POST',
				url: url,
				data:
				{ 
					current_time: Math.floor($('#video-player')[0].currentTime),
					video_id: "{{ $video_id }}"
				}
			});
		}

		$(function()
		{
			loadVideo();
			loadVideoHistory();
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
					var $this = $(this);
					$this.addClass('word-hover');

					if (!$this.data('definition'))
						hoverTimer = setTimeout(function() { loadAdminDefinition($this); }, 500);
				})
				.on('mouseleave', 'span[data-type=word]', function()
				{
					$(this).removeClass('word-hover');
					clearTimeout(hoverTimer);
				})
				.on('mouseenter', 'span[data-type=nonDefinedWord]', function()
				{
					var $this = $(this);
					$this.addClass('word-hover');
					hoverTimer = setTimeout(function() { loadDictionaryDefinition($this, initNonDefinedWordData); }, 500);
				})
				.on('mouseleave', 'span[data-type=nonDefinedWord]', function()
				{
					$(this).removeClass('word-hover');
					clearTimeout(hoverTimer);
				})
				.on('mouseenter', 'span[data-type=definedWord]', function()
				{
					$(this).addClass('word-hover');
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
			
			// Handle when the video is completely loaded
			$('#video-player').bind('loadeddata', videoLoaded);

			$('#flashcard').on('click', '.play-pronunciation', function()
			{
				playAudio($(this).data('audio-url').split(' '));
			});

			// Handle when the user leaves the page without going to the quiz
			$(window).unload(function() { 
				saveVideoHistory(); // Call this from the console to test
			});
		});
	</script>
@stop
