@extends('admin.master')


@section('content')

<div class="container">

	<?php
	//$script contains the full string of the script
	$words = explode(" ", $script);
	
	
	echo Form::open(array('url' => 'admin/definitions')) . "\n";
	echo Form::hidden('script_id', $script_id) . "\n";
	foreach($words as $word)
	{
		echo Form::label('definitions['.$word.']', $word);
		echo Form::text('definitions['.$word.']');
		echo "<br/>\n";
	}
	echo Form::submit() . "\n";
	echo Form::close() . "\n";
	?>
	
</div>

@stop