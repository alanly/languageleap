@extends('master')

@section('css')
	<style>
		.cover img {
			margin-bottom: 0;
			height: 277px;
			width: 208px;
		}

		.element {
			padding: 5px;
			display: inline-block;
		}

		.element img:hover {
			opacity: 0.5;
		}

		.nav-pills {
			margin-bottom: 15px;
			margin-right: 15px;
		}

		.loading-overlay {
			background-color: #e4e4e4;
			left: 15px;
			right: 15px;
			position: absolute;
			opacity: 0.5;
		}

		.vertical-center {
			min-height: 100%;
			min-height: 75vh;

			display: flex;
			align-items: center;
		}

		.content {
			padding: 0 15px 0 15px;
		}

	</style>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<ul class="nav nav-pills col-md-9" role="tablist">
					<li role="presentation" class="active"><a href=".movies" aria-controls="movies" role="tab" data-toggle="tab">@lang('index.layout.tabs.movies')</a></li>
					<li role="presentation"><a href=".shows" aria-controls="shows" role="tab" data-toggle="tab">@lang('index.layout.tabs.shows')</a></li>
					<li role="presentation"><a href=".commercials" aria-controls="commercials" role="tab" data-toggle="tab">@lang('index.layout.tabs.commercials')</a></li>
				</ul>
			</div>
			<div id="search" class="pull-right col-md-3">
				<input type="text" class="form-control" placeholder="@lang('index.layout.search.for')">
			</div>
		</div>
		<div class="row">
			<div role="tabpanel" class="content col-md-12">
				<div class="loading-overlay vertical-center">
					{{ HTML::image('/img/misc/loading-main.gif', 'Loading', array('class' => 'center-block loading')) }}
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active section movies" data-type="movie">
						<div class="elements movie-elements">
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section shows" data-type="show">
						<div class="elements show-elements">
						</div>
					</div>
					<div role="tabpanel" class="tab-pane section commercials" data-type="commercial">
						<div class="elements commercial-elements">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		/**
		* Given a type (ie. movie), will build a 
		* query in JSON format suited for that type.
		*/
		function buildQueryData(type) {
			var typeQueryData;
			var commonQueryData = getCommonQueryData();

			if (type == 'movie')
				typeQueryData = getMovieQueryData();
			else if (type == 'show')
				typeQueryData = getShowQueryData();
			else
				typeQueryData = getCommercialQueryData();

			// Merge param2 into param1
			$.extend(commonQueryData, typeQueryData);

			return commonQueryData;
		}


		/**
		* Returns a JSON of query data that
		* represents the 'movie' type.
		*/
		function getMovieQueryData() {
			var searchText = getSearchText();
			
			return {
				'type': 'movie',
				'director': searchText,
				'actor': searchText,
				'genre': searchText
			};
		}

		/**
		* Returns a JSON of query data that
		* represents the 'show' type.
		*/
		function getShowQueryData() {
			var searchText = getSearchText();
			
			return {
				'type': 'show',
				'director': searchText
			};
		}

		/**
		* Returns a JSON of query data that
		* represents the 'commercial' type.
		*/
		function getCommercialQueryData() {
			var searchText = getSearchText();
			
			return {
				'type': 'commercial'
			};
		}

		/**
		* Returns a JSON of query data that is
		* common to all types.
		*/
		function getCommonQueryData() {
			var searchText = getSearchText();

			return {
				'take': 10,
				'skip': 0,
				'name': searchText
			};
		}

		/**
		* Retrieves the text that is in the searchbox.
		*/
		function getSearchText() {
			return $('#search input').val();
		}

		/**
		* Retrieves the string type to be sent to the server
		* for filtering.
		*/
		function getActiveTabType() {
			return getActivePanel().data('type');
		}

		/**
		* Returns the panel with the given type as a
		* jQuery object.
		*/
		function getPanelWithType(type) {
			return $('.tab-content [data-type=' + type + ']');
		}

		/**
		* Returns the panel that is currently
		* displayed (as a jQuery object).
		*/
		function getActivePanel() {
			return $('.tab-content .active');
		}

		/**
		* Show the loading overlay with a bit of
		* delay and animation to provide a more natural loading feeling.
		*/
		function showLoadingOverlay() {
			$('.loading-overlay').removeClass('hide', 200, 'linear');
		}

		/**
		* Hide the loading overlay with a bit of
		* delay and animation to provide a more natural loading feeling.
		*/
		function hideLoadingOverlay() {
			$('.loading-overlay').addClass('hide', 200, 'linear');
		}


		/**
		* A timer is used to reduce the number of requests
		* to the server.
		*/
		window.filterTimeout = null;
		function onSearchInput() {
			showLoadingOverlay();
			clearTimeout(filterTimeout);
			filterTimeout = setTimeout(refreshFilteredData, 600);
		}

		/**
		* This function is called when the user switches panels.
		*/
		function onSwitchPanel() {
			showLoadingOverlay();
			refreshFilteredData();
		}

		/**
		* Will refresh the content to reflect the currently
		* set filters.
		*/
		function refreshFilteredData() {
			var type = getActiveTabType();
			var data = buildQueryData(type);

			$.ajax({
				type: 'GET',
				data: data,
				dataType: 'JSON',
				url: '/api/metadata/filter',
				success: onGetFilteredSuccess(type),
				error: onGetFilteredFail
			});
		}

		function refreshPopovers() {
			$('[data-toggle="popover"]').popover();
		}

		/**
		* This function is called upon successful
		* interaction with the server for filtered results.
		*/
		function onGetFilteredSuccess(type) {
			return function(data) {
				hideLoadingOverlay();

				var $panel = getPanelWithType(type);

				// Empty the panel
				$panel.children('.elements').empty();

				if (data.data.length > 0) {
					$.each(data.data, function(i, v) {
						addElementToPanel($panel, type, v);
					});

					refreshPopovers();
				} else {
					showNoResults($panel);
				}
			};
		}

		/**
		* Shows an alert in the given panel to let
		* the user know that no results were returned.
		*/
		function showNoResults($panel) {
			var noResults = '<div class="alert" role="alert">' +
								'<h2><small>@lang("index.layout.search.empty")</small></h2>' +
							'</div>';

			$panel.children('.elements').html(noResults);
		}

		/**
		* This function is called when filtered results
		* retrieval has failed.
		*/
		function onGetFilteredFail(data) {
			hideLoadingOverlay();

			var message = data.responseJSON.data;

			if(message === undefined)
				message = '@lang("index.layout.filter.error")';
			
			var error = '<div class="alert alert-danger" role="alert">' + message + '</div>';
			$('.tab-content .active .elements').html(error);
		}

		/**
		* Constructs an element with the given type and data
		* and adds it to the given panel.
		*/
		function addElementToPanel($panel, type, elementData) {
			var url = '/' + type + '/' + elementData.id;
			var coverUrl = (elementData.image_path) ? elementData.image_path : 'http://placehold.it/208x277';
			var element =	'<div class="element" id="' + elementData.id + '">' +
								'<a href="' + url + '" class="thumbnail cover" data-toggle="popover" data-trigger="hover" data-placement="auto" title="' + elementData.name + '" data-content="' + elementData.description + '">' +
									'<img src="' + coverUrl + '" />' +
								'</a>' +
							'</div>';

			$panel.children('.elements').append(element);
		}

		/**
		* Loads the initial content with no filters applied.
		*/
		function loadInitialContent() {
			refreshFilteredData();
		}

		$(document).ready(function() {
			// Load the content for the active panel
			loadInitialContent();

			// Handler for when the user types in the search box
			$('#search input').on('input', onSearchInput);

			// Handler for when the user switches panel
			$(document).on('hidden.bs.tab', onSwitchPanel);
		});
			
	</script>
@stop
