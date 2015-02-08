@extends('master')

@section('css')
	<style>
		.cover img {
			margin-bottom: 0;
			height: 240px;
			width: 180px;
		}

		.element {
			padding: 5px;
			display: inline-block;
		}

		.element:hover {
		  opacity: 0.4;
		}

		.filters-toggle {
			border-right: 1px solid #DDD;
			border-bottom: 1px solid #DDD;
			border-top: 1px solid #DDD;
			cursor: pointer;
			height: 40px;
			padding: 10px;

			margin-bottom: 15px;
		}

		.nav-pills {
			margin-bottom: 15px;
			margin-right: 15px;
		}

		.hide-filters-text span {
			display: inline-block;
			width: 85px;
		}

		.hide-filters-text {
			display: inline-block;
			padding-left: 20px;
		}

		.filters-toggle .glyphicon {
			top: 2px;
		}

		#genres .checkbox {
			display: inline-block;
			max-width: 200px;
			width: 100%;
		}
	</style>
@stop

@section('content')
	<div class="container-fluid">
		<div class="row">
			<ul class="nav nav-pills navbar-right" role="tablist">
				<li role="presentation" class="active"><a href=".movies" aria-controls="movies" role="tab" data-toggle="tab">Movies</a></li>
				<li role="presentation"><a href=".shows" aria-controls="shows" role="tab" data-toggle="tab">TV Shows</a></li>
				<li role="presentation"><a href=".commercials" aria-controls="commercials" role="tab" data-toggle="tab">Commercials</a></li>
			</ul>
			<div class="filters-toggle pull-left">
				<span class="hide-filters-text">
					<span>Hide filters</span>
				</span>
				<span class="glyphicon glyphicon-chevron-left pull-right"></span>
				<span class="glyphicon glyphicon-chevron-right pull-right hide"></span>
			</div>
		</div>
		<div class="row">
			<div class="filters col-md-2">
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#search">Search</div>
					<div id="search" class="panel-body collapse in">
						<input type="text" class="form-control" placeholder="Search for...">
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#genres">Genres</div>
					<div id="genres" class="panel-body collapse in">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Action
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Animated
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Family
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Comedy
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Crime
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Documentary
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Drama
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Holidays
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Horror
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								Music
							</label>
						</div>
					</div>
				</div>				
			</div>
			<div role="tabpanel" class="content">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active section movies">
						<div class="elements">
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section shows">
						<div class="elements">
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section commercials">
						<div class="elements">
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/>
								</a>
							</div>
							<div class="element">
								<a href="#" class="thumbnail cover">
									<img src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		function toggleFilters() {
			$('.filters').animate({ width: 'toggle' }, 350);
			$('.hide-filters-text').animate({ width: 'toggle' }, 350);
			$('.filters-toggle .glyphicon').toggleClass('hide');
		}

		$(document).ready(function() {
			$('.filters-toggle').click(toggleFilters);
		});
			
	</script>
@stop