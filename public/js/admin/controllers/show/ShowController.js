(function() {

	var app = angular.module('adminApp');

	app.controller('ShowController', ['$scope', '$log', '$routeParams', '$http', '$modal', function($scope, $log, $routeParams, $http, $modal) {

		$scope.shows = [];

		// Load all of the shows
		$http.get('/api/metadata/shows').
			success(function(data) {
				$scope.shows = data.data;
			});

		// Delete button handler
		$scope.onDeleteShowClick = function($event, show) {
			var index = $scope.shows.indexOf(show);
			$scope.shows.splice(index, 1);

			$scope.deleteShow(show);
		};

		// Publish checkbox handler
		$scope.onPublishClick = function($event, show) {
			show.is_published = $event.target.checked;
			$scope.updateShow(show);
		};

		// Update a given show
		$scope.updateShow = function(show) {
			$http.put('/api/metadata/shows/' + show.id, show);
		};

		// Delete a given show
		$scope.deleteShow = function(show) {
			$http.delete('/api/metadata/shows/' + show.id);
		};

		// Open the edit modal
		$scope.openEditModal = function(show) {

			var modalInstance = $modal.open({
				templateUrl: 'partials/edit-show-modal',
				controller: 'EditShowController',
				size: 'lg',
				resolve: {
					show: function() { return show; }
				},
				backdrop: 'static',
				backdropClass: 'modal-backdrop-fix'
			});

		};

		$scope.loadSeasons = function(show) {

			if (show.seasons) {
				var seasons = $('.show-' + show.id);
				seasons.toggle();

				// If the seasons are not shown, do not show the episodes
				if (! seasons.is(':visible')) 
					seasons.nextAll('tr').hide();
			} else {
				$http.get('/api/metadata/shows/' + show.id + '/seasons').
					success(function(data) {
						show.seasons = data.data.seasons;
					});
			}

		};

		$scope.loadEpisodes = function(show, season) {

			if (season.episodes) {
				$('.season-' + season.id).toggle();
			} else {
				$http.get('/api/metadata/shows/' + show.id + '/seasons/' + season.id + '/episodes').
					success(function(data) {
						season.episodes = data.data.episodes;
					});
			}

		};

	}]);

	app.controller('EditShowController', ['$scope', '$log', '$routeParams', '$http', '$modalInstance', 'show', function($scope, $log, $routeParams, $http, $modalInstance, show) {
		
		$scope.show = angular.copy(show);

		// Save the updated show
		$scope.saveShow = function() {
			$http.put('/api/metadata/shows/' + $scope.show.id, $scope.show).
				success(function(data){
					// Copy the changed data back to the binded show object
					angular.copy($scope.show, show);
					$modalInstance.dismiss('saved');
				});
		};

		// Cancel any changes that were made
		$scope.cancelEdit = function() {
			$modalInstance.dismiss('cancel');
		};

	}]);

})();