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
				<p>Your browser does not support HTML5 video.</p>
			</video>
		</div>

		<div id="script">
		</div>

		<a class="continue btn btn-success">Continue to Quiz</a>
		<a class="define btn btn-primary">Define Selected</a>
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
		var timer;

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
			//REMOVE
			loadScript();
			//REMOVE
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
				var $this = $(this);

				$this.tooltip({
						'container': '#script',
						'placement': 'auto top',
						'title': 'Loading...'
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
				scriptHtml = scriptHtml.replace(regex, "<span data-type='nonDefinedWord'>" + words[i] + "</span>");
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

		function getDefinition(word)
		{
			timer = setTimeout(function()
			{ 
				alert("hi");
				/*$.getJSON('/api/metadata/definitions/' + word, function(data) {
				var defintion = "Defintion not found";

				if (data.status == 'success')
				{
					defintion = data.data.definition;
				}

				$word.tooltip({
						'container': '#script',
						'placement': 'auto top',
						'title': definition;
					});
				});
			
				$word.tooltip({
						'container': '#script',
						'placement': 'auto top',
						'title': defintion
				});*/
			}, 3000);

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
				})
				.on('mouseenter', 'span[data-type=nonDefinedWord]', function()
				{
					$(this).addClass('word-hover');
					getDefinition($(this));
				})
				.on('mouseleave', 'span[data-type=nonDefinedWord]', function()
				{
					$(this).removeClass('word-hover');
					clearTimeout(timer);
				});

			$('#script').on('click', 'span[data-type=word]', function()
			{
				$(this).toggleClass('word-selected');
			});
		});
	</script>
@stop
