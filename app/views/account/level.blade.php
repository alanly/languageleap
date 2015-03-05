@extends('master')

@section('content')

<div class="container">

	<h2>@lang('account.level.level')</h2>
	<hr>
	<div class="jumbotron">
		<h1>{{ $level->description }}</h1>
	</div>

</div>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop