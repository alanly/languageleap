@extends('master')

@section('css')
	<style>
		.cover img {
			height: 300px;
			width: 225px;
		}

		.thumbnail.cover {
			width: 225px;
		}

		.video-selection tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('content')
	<div class="container">
		<h2>Arrow <small><em>(Science Fiction)</em></small></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg" />
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<span class="director col-md-4 col-xs-6">
						<h3>Director</h3>
						<p>Will Smith</p>
					</span>
					<span class="starring col-md-4 col-xs-6">
						<h3>Starring</h3>
						<p>Samuel Jackson, Seth Junior</p>
					</span>
				</div>
				<span class="description">
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</span>
				<br>
				<div class="season-selection panel-group" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading-1">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent=".season-selection" href=".season-1" aria-expanded="false" aria-controls="season-1">
									Season 1
								</a>
							</h4>
						</div>
						<div class="season-1 panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">
							<div class="panel-body">
								<ul class="list-group">
									<li class="list-group-item"><a href="#">Episode 1</a></li>
									<li class="list-group-item"><a href="#">Episode 2</a></li>
									<li class="list-group-item"><a href="#">Episode 3</a></li>
									<li class="list-group-item"><a href="#">Episode 4</a></li>
									<li class="list-group-item"><a href="#">Episode 5</a></li>
									<li class="list-group-item"><a href="#">Episode 6</a></li>
									<li class="list-group-item"><a href="#">Episode 7</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading-2">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent=".season-selection" href=".season-2" aria-expanded="false" aria-controls="season-2">
									Season 2
								</a>
							</h4>
						</div>
						<div class="season-2 panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
							<div class="panel-body">
								<ul class="list-group">
									<li class="list-group-item"><a href="#">Episode 1</a></li>
									<li class="list-group-item"><a href="#">Episode 2</a></li>
									<li class="list-group-item"><a href="#">Episode 3</a></li>
									<li class="list-group-item"><a href="#">Episode 4</a></li>
									<li class="list-group-item"><a href="#">Episode 5</a></li>
									<li class="list-group-item"><a href="#">Episode 6</a></li>
									<li class="list-group-item"><a href="#">Episode 7</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading-3">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent=".season-selection" href=".season-3" aria-expanded="false" aria-controls="season-3">
									Season 3
								</a>
							</h4>
						</div>
						<div class="season-3 panel-collapse collapse" role="tabpanel" aria-labelledby="heading-3">
							<div class="panel-body">
								<ul class="list-group">
									<li class="list-group-item"><a href="#">Episode 1</a></li>
									<li class="list-group-item"><a href="#">Episode 2</a></li>
									<li class="list-group-item"><a href="#">Episode 3</a></li>
									<li class="list-group-item"><a href="#">Episode 4</a></li>
									<li class="list-group-item"><a href="#">Episode 5</a></li>
									<li class="list-group-item"><a href="#">Episode 6</a></li>
									<li class="list-group-item"><a href="#">Episode 7</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

	</script>
@stop