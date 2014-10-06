@extends('admin.master')


@section('content')

<div class="container">

	<?php
	//$script contains the full string of the script
	$script = Session::get('script');
	$script_id = Session::get('script_id');
	
	$words = explode(" ", $script);
	
	echo Form::open(array('url' => 'api/metadata/words')) . "\n";
	echo Form::hidden('script_id', $script_id) . "\n";
	echo '<table>'."\n";
	echo '<th>Word</th><th>Definition</th><th>Full Definition</th><th>Pronunciation</th>'."\n";
	foreach($words as $word)
	{
		echo '<tr>';
		echo '<td>' . Form::label('definitions['.$word.']', $word) . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][def]') . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][full_def]') . '</td>';
		echo '<td>' . Form::text('definitions['.$word.'][pronun]') . '</td>';
		echo "</tr><br/>\n";
	}
	echo '</table><br/>'."\n";
	echo Form::submit() . "\n";
	echo Form::close() . "\n";
	?>
	
</div>

@stop