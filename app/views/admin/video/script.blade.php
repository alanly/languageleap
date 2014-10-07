@extends('admin.master')

@section('head')
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
		echo '<tr>';
		echo '<td>' . Form::label('definitions['.$word.']', $word) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][def]', null, $attributes = array('class'=>'load-definitions', 'data-word'=>$word)) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][full_def]') . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][pronun]') . '</td>';
		echo "</tr><br/>\n";
	}
	echo '</table><br/>'."\n";
	echo Form::submit() . "\n";
	echo Form::close() . "\n";
	?>
	
</div>

<script type="text/javascript">
	var definitions;
	$(".load-definitions").focus(function() {
		definitions = [];
		
		$.ajax(
			type: "GET",
			url: "../../api/metadata/words/" + this.dataset.word, 
			dataType: "json",
			async: false,
			success: function(response) {
				if(response.data)
				{
					for(var i = 0; i < response.data.length; i++)
					{
						definitions.push(response.data[i].definition);
						console.log(response.data[i].definition);
					}
				}
			}
		);
		
		/*$(this).typeahead({
			hint: true,
			highlight: true,
			minLength: 1,
		},
		{
			name: 'definitions',
			displayKey: 'value',
			source: substringMatcher(definitions)
		});*/
	});
	
	
</script>

@stop