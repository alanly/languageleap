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

		.element > img:hover {
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
				<li role="presentation" class="active"><a href=".movies" aria-controls="movies" role="tab" data-toggle="tab" onclick="loadMovies();">@lang('index.layout.tabs.movies')</a></li>
				<li role="presentation"><a href=".shows" aria-controls="shows" role="tab" data-toggle="tab" onclick="loadShows();">@lang('index.layout.tabs.shows')</a></li>
				<li role="presentation"><a href=".commercials" aria-controls="commercials" role="tab" data-toggle="tab" onclick="loadCommercials();">@lang('index.layout.tabs.commercials')</a></li>
			</ul>
			<div class="filters-toggle pull-left">
				<span class="hide-filters-text">
					<span>@lang('index.layout.filters.hide')</span>
				</span>
				<span class="glyphicon glyphicon-chevron-left pull-right"></span>
				<span class="glyphicon glyphicon-chevron-right pull-right hide"></span>
			</div>
		</div>
		<div class="row">
			<div class="filters col-md-2">
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#search">@lang('index.layout.search.search')</div>
					<div id="search" class="panel-body collapse in">
						<input type="text" class="form-control" placeholder="@lang('index.layout.search.for')">
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#genres">@lang('index.layout.filters.genre')</div>
					<div id="genres" class="panel-body collapse in">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="">
								@lang('index.layout.filters.action')
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
			<div role="tabpanel" class="content col-md-10">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active section movies">
						<div class="elements movie-elements">
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section shows">
						<div class="elements show-elements">
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section commercials">
						<div class="elements commercial-elements">
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
			$('.content').toggleClass('col-md-10');
		}

		$(document).ready(function() {
			loadMovies();
			$('.filters-toggle').click(toggleFilters);
		});

		function loadMovies()
		{
			//AJAX call to get all the movies here.
			$.ajax({
				type : "GET",
				dataType : "JSON",
				url : "/api/metadata/movies",
				success : function(data){
					var movies = "";
					$.each(data.data, function(index,value){

						var cover = "http://placehold.it/180x240";

						if(value.cover != null)
						{
							cover = index.cover;
						}

						movies += "<div class='element' id='" + value.id + "'>" 
									+ "<a href='/movie/" + value.id + "' class='thumbnail cover' data-toggle='popover' data-trigger='hover' data-placement='auto' title='" + value.name + "' data-content='" + value.description + "'>"
									+ "<img src='" + cover + "'/>"
									+ "</a>"
									+ "</div>";
					});

					$(".movie-elements").html(movies);
					$('[data-toggle="popover"]').popover();
				},
				error : function(data){
					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "There was a problem loading the information, Please try again at a later time.";
					}

					var error = "<div class='alert alert-danger' role='alert'>" + message + "</div>";
					$(".movie-elements").html(error);
				}
			});
		}

		function loadCommercials()
		{
			//AJAX call to get all the movies here.
			$.ajax({
				type : "GET",
				dataType : "JSON",
				url : "/api/metadata/commercials",
				success : function(data){
					var commercials = "";
					$.each(data.data, function(index,value){
					
						var cover = "http://placehold.it/180x240";

						if(value.cover != null)
						{
							cover = value.cover;
						}

						commercials += "<div class='element' id='" + value.id + "'>" 
									+ "<a href='/commercial/" + value.id + "' class='thumbnail cover' data-toggle='popover' data-trigger='hover' data-placement='auto' title='" + value.name + "' data-content='" + value.description + "'>"
									+ "<img src='" + cover + "'/>"
									+ "</a>"
									+ "</div>";
					});

					$(".commercial-elements").html(commercials);
					$('[data-toggle="popover"]').popover();
				},
				error : function(data){
					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "There was a problem loading the information, Please try again at a later time.";
					}
					
					var error = "<div class='alert alert-danger' role='alert'>" + message + "</div>";
					$(".movie-elements").html(error);
				}

			});
		}

		function loadShows()
		{
			//AJAX call to get all the movies here.
			$.ajax({
				type : "GET",
				dataType : "JSON",
				url : "/api/metadata/shows",
				success : function(data){
					var shows = "";
					$.each(data.data, function(value,value){
					
						var cover = "http://placehold.it/180x240";

						if(value.cover != null)
						{
							cover = value.cover;
						}

						shows += "<div class='element' id='" + value.id + "'>" 
									+ "<a href='/show/" + value.id + "' class='thumbnail cover' data-toggle='popover' data-trigger='hover' data-placement='auto' title='" + value.name + "' data-content='" + value.description + "'>"
									+ "<img src='" + cover + "'/>"
									+ "</a>"
									+ "</div>";
					});

					$(".show-elements").html(shows);
					$('[data-toggle="popover"]').popover();
				},
				error : function(data){
					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "There was a problem loading the information, Please try again at a later time.";
					}
					
					var error = "<div class='alert alert-danger' role='alert'>" + message + "</div>";
					$(".movie-elements").html(error);
				}

			});
		}
			
	</script>
		}
@stop