@extends('admin.master')


@section('content')

<div class="container">

	<?php
	//$script contains the full string of the script
	$words = explode(" ", $script);
	foreach($words as $word)
	{
		echo $word . "<br/>";
	}
	?>
	
</div>

@stop