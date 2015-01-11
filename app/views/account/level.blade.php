@extends('master')

@section('content')

<div class="container">
	<div class="page-header">
		<nav>
			<ul class="nav nav-pills pull-right">
				<li role="presentation" class="active"><a href="#">My Level</a></li>
				<li role="presentation"><a href="#">About</a></li>
				<li role="presentation"><a href="#">Contact</a></li>
			</ul>
		</nav>
		<h3 class="text-muted">Language Leap</h3>
	</div>

	
	<div class="jumbotron">
		<h1>{{ $level->description }}</h1>
	</div>

</div>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop