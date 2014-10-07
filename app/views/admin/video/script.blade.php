@extends('admin.master')

@section('head')
	<link rel="stylesheet" href="/libraries/typeahead/css/style.css"/>

	<script type="text/javascript" src="/libraries/typeahead/js/typeahead.bundle.min.js"></script>
	<script type="text/javascript" src="/libraries/typeahead/js/typeahead.jquery.min.js"></script>
	
	<script>
	var substringMatcher = function(strs) 
	{
		return function findMatches(q, cb) 
		{
			var matches, substrRegex;
 
			// an array that will be populated with substring matches
			matches = [];

			// regex used to determine if a string contains the substring `q`
			substrRegex = new RegExp(q, 'i');

			// iterate through the pool of strings and for any string that
			// contains the substring `q`, add it to the `matches` array
			$.each(strs, function(i, str) 
			{
				if (substrRegex.test(str)) 
				{
					// the typeahead jQuery plugin expects suggestions to a
					// JavaScript object, refer to typeahead docs for more info
					matches.push({ value: str });
				}
			});

		cb(matches);
		};
	};
	</script>
@stop

@section('content')

<div class="container">

	<?php
	//$script contains the full string of the script
	$script = Session::get('script');
	$script_id = Session::get('script_id');
	
	$script = strtolower($script);
	$script = preg_replace('/[^[:alpha:] ]/', '', $script);
	$words = explode(" ", $script);
	
	echo Form::open(array('url' => 'api/metadata/words')) . "\n";
	echo Form::hidden('script_id', $script_id) . "\n";
	echo '<table>'."\n";
	echo '<th>Word</th><th>Definition</th><th>Full Definition</th><th>Pronunciation</th>'."\n";
	foreach($words as $word)
	{
		if(!$word)
		{
			continue;
		}
		echo '<tr>';
		echo '<td>' . Form::label('definitions['.$word.']', $word) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][def]', null, array('class'=>'load-definitions tt-query', 'data-word'=>$word)) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][full_def]', null, array('class'=>'tt-query')) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][pronun]', null, array('class'=>'tt-query')) . '</td>';
		echo "</tr><br/>\n";
	}
	echo '</table><br/>'."\n";
	echo Form::submit() . "\n";
	echo Form::close() . "\n";
	?>
	
</div>

<script type="text/javascript">
	
	var definitionBoxes = $(".load-definitions");
	var data = ['{"words":['];
	for(var i = 0; i < definitionBoxes.length; i++)
	{
		if(i != definitionBoxes.length - 1)
		{
			data.push('"' + definitionBoxes[i].dataset.word + '",');
		}
		else
		{
			data.push('"' + definitionBoxes[i].dataset.word + '"');
		}
	}
	data.push(']}');
	data = data.join('');
	data = $.parseJSON(data);
	
	$.ajax({
		type: "POST",
		url: "/api/metadata/words/definitions",
		data: data,
		dataType: "json",
		async: false,
		success: function(response, textstatus, xhr)
		{
			data = response.data;
		}
	});
	
	for(var i = 0; i < definitionBoxes.length; i++)
	{
		var definitions = [];
		var wordData = eval("data." + definitionBoxes[i].dataset.word);
		if(wordData) // Get the data of the specific word
		{
			for(var j = 0; j < wordData.length; j++)
			{
				definitions.push(wordData[j].definition);
			}
		}
		
		if(definitions.length > 0) // Create a typeahead if there is at least one definition
		{
			$(definitionBoxes[i]).typeahead({
				hint: true,
				highlight: true,
				minLength: 1
			},
			{
				name: 'definition',
				source: substringMatcher(definitions)
			});
		}
	}
	
</script>

@stop