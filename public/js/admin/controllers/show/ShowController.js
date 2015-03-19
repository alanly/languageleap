(function() {

	var app = angular.module('adminApp');

	app.controller('ShowController', ['$scope', '$log', '$routeParams', '$http', '$modal', function($scope, $log, $routeParams, $http, $modal) {

		$scope.shows = [];

		// Load all of the shows
		$http.get('/api/metadata/shows').
			success(function(data) {
				$scope.shows = data.data;
			});

		// Delete button handlers
		$scope.onDeleteShowClick = function($event, show) {
			var index = $scope.shows.indexOf(show);
			$scope.shows.splice(index, 1);

			$scope.deleteShow(show);
		};

		$scope.onDeleteSeasonClick = function($event, show, season) {
			var showIndex = $scope.shows.indexOf(show);
			var seasonIndex = $scope.shows[showIndex].seasons.indexOf(season);
			$scope.shows[showIndex].seasons.splice(seasonIndex, 1);

			$scope.deleteSeason(show, season);
		};

		$scope.onDeleteEpisodeClick = function($event, show, season, episode) {
			var showIndex = $scope.shows.indexOf(show);
			var seasonIndex = $scope.shows[showIndex].seasons.indexOf(season);
			var episodeIndex = $scope.shows[showIndex].seasons[seasonIndex].episodes.indexOf(episode);
			$scope.shows[showIndex].seasons[seasonIndex].episodes.splice(episodeIndex, 1);

			$scope.deleteEpisode(show, season, episode);
		};

		// Publish checkbox handlers
		$scope.onPublishShowClick = function($event, show) {
			show.is_published = $event.target.checked;
			$scope.updateShow(show);
		};

		$scope.onPublishSeasonClick = function($event, show, season) {
			season.is_published = $event.target.checked;
			$scope.updateSeason(show, season);
		};

		$scope.onPublishEpisodeClick = function($event, show, season, episode) {
			episode.is_published = $event.target.checked;
			$scope.updateEpisode(show, season, episode);
		};

		$scope.updateShow = function(show) {
			$http.put('/api/metadata/shows/' + show.id, show);
		};

		$scope.updateSeason = function(show, season) {
			$http.put('/api/metadata/shows/' + show.id + '/seasons/' + season.id, season);
		};

		$scope.updateEpisode = function(show, season, episode) {
			$http.put('/api/metadata/shows/' + show.id + '/seasons/' + season.id + '/episodes/' + episode.id, episode);
		};

		$scope.deleteShow = function(show) {
			$http.delete('/api/metadata/shows/' + show.id);
		};

		$scope.deleteSeason = function(show, season) {
			$http.delete('/api/metadata/shows/' + show.id + '/seasons/' + season.id);
		};

		$scope.deleteEpisode = function(show, season, episode) {
			$http.delete('/api/metadata/shows/' + show.id + '/seasons/' + season.id + '/episodes/' + episode.id);
		};

		// Open the edit modal for shows
		$scope.openShowEditModal = function(show) {
			console.log("here");
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

		// Open the edit modal for seasons
		$scope.openSeasonEditModal = function(show, season) {

			var modalInstance = $modal.open({
				templateUrl: 'partials/edit-season-modal',
				controller: 'EditSeasonController',
				size: 'lg',
				resolve: {
					show: function() { return show; },
					season: function() { return season; }
				},
				backdrop: 'static',
				backdropClass: 'modal-backdrop-fix'
			});

		};

		// Open the edit modal for episodes
		$scope.openEpisodeEditModal = function(show, season, episode) {

			var modalInstance = $modal.open({
				templateUrl: 'partials/edit-episode-modal',
				controller: 'EditEpisodeController',
				size: 'lg',
				resolve: {
					show: function() { return show; },
					season: function() { return season; },
					episode: function() { return episode; }
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

	app.controller('EditSeasonController', ['$scope', '$log', '$routeParams', '$http', '$modalInstance', 'show', 'season', function($scope, $log, $routeParams, $http, $modalInstance, show, season) {
		
		$scope.season = angular.copy(season);

		// Save the updated season
		$scope.saveSeason = function() {
			$http.put('/api/metadata/shows/' + show.id + '/seasons/' + $scope.season.id, $scope.season).
				success(function(data){
					// Copy the changed data back to the binded show object
					angular.copy($scope.season, season);
					$modalInstance.dismiss('saved');
				});
		};

		// Cancel any changes that were made
		$scope.cancelEdit = function() {
			$modalInstance.dismiss('cancel');
		};

	}]);

	app.controller('EditEpisodeController', ['$scope', '$log', '$routeParams', '$http', '$modalInstance', 'show', 'season', 'episode', function($scope, $log, $routeParams, $http, $modalInstance, show, season, episode) {
		
		$scope.episode = angular.copy(episode);

		// Save the updated episode
		$scope.saveEpisode = function() {
			$http.put('/api/metadata/shows/' + show.id + '/seasons/' + season.id + '/episodes/' + $scope.episode.id, $scope.episode).
				success(function(data){
					// Copy the changed data back to the binded show object
					angular.copy($scope.episode, episode);
					$modalInstance.dismiss('saved');
				});
		};

		// Cancel any changes that were made
		$scope.cancelEdit = function() {
			$modalInstance.dismiss('cancel');
		};

	}]);

})();