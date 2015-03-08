(function() {

	var app = angular.module('adminApp');

	app.controller('ShowController', ['$scope', '$log', '$routeParams', '$http', function($scope, $log, $routeParams, $http) {

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

	}]);

})();