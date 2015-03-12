@extends('master')

@section('content')

<div class="container">
	<div class="page-header">
		<nav>
			<ul class="nav nav-pills pull-right">
				<li role="presentation" class="active"><a href="#">@lang('account.level.level')</a></li>
				<li role="presentation"><a href="#">@lang('account.level.about')</a></li>
				<li role="presentation"><a href="#">@lang('account.level.contact')</a></li>
			</ul>
		</nav>
		<h3 class="text-muted">@lang('sitename.name.no_space')</h3>
	</div>
	<h2>@lang('account.level.level')</h2>
	<hr>
	<div class="jumbotron">
		<h1>{{ $level->description }}</h1>
	</div>

</div>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop