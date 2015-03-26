@extends('master')

@section('content')

<div class="container">
	<div class="page-header">
		<h2>
			@lang('account.level.level')
			<br>
			<small>@lang('account.level.subtitle')</small>
		</h2>
	</div>

	<div class="jumbotron">
		<h1>{{ $level->description }}</h1>
	</div>

</div>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop