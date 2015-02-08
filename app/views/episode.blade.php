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
		<h2>How I Met Your Mother<br> <small><em>Season 1, Episode 2</em></small></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg" />
				</div>
			</div>
			<div class="col-md-9">
				<span class="level">
					<h3>Difficulty Level</h3>
					<p>Advanced</p>
				</span>
				<span class="episode-name">
					<h3>Title</h3>
					<p>There was a place far away</p>
				</span>
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
				<span class="video-selection">
					<div class="panel panel-default">
						<!-- Table -->
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Part Number</th>
									<th>Viewed</th>
									<th>Length</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td><span class="glyphicon glyphicon-eye-open"></span></td>
									<td>0:30</td>
								</tr>
								<tr>
									<td>2</td>
									<td><span class="glyphicon glyphicon-eye-open"></span></td>
									<td>0:30</td>
								</tr>
								<tr>
									<td>3</td>
									<td><span class="glyphicon glyphicon-eye-close"></span></td>
									<td>0:30</td>
								</tr>
								<tr>
									<td>4</td>
									<td><span class="glyphicon glyphicon-eye-open"></span></td>
									<td>0:30</td>
								</tr>
							</tbody>	
						</table>
					</div>
				</span>
			</div>
		</div>
	</div>

	<script type="text/javascript">

	</script>
@stop