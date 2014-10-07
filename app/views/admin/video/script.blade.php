@extends('admin.master')

@section('head')

	<!-- Need autocomplete library here -->

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
		$.getJSON("../../api/metadata/words/" + this.dataset.word, function(response) {
			if(response.data)
			{
				for(var i = 0; i < response.data.length; i++)
				{
					definitions.push(response.data[i].definition);
					console.log(response.data[i].definition);
				}
			}
		});
	});
</script>

@stop