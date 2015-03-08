(function() {

	var app = angular.module('adminApp');

	app.controller('MovieController', ['$scope', '$log', '$routeParams', '$http', function($scope, $log, $routeParams, $http) {

		$scope.movies = [];

		// Load all of the movies
		$http.get('/api/metadata/movies').
			success(function(data) {
				//get the movies from the server and set it.
				$scope.movies = data.data;
			}
		);
		
		$scope.remove = function(movie){
			
			$http.delete('/api/metadata/movies/' + movie.id);

			var index = $scope.movies.indexOf(movie);
			$scope.movies.splice(index, 1);

		};

		// Publish checkbox handler
		$scope.onPublishClick = function($event, movie) {
			movie.is_published = $event.target.checked;
			$scope.updateMovie(movie);
		};

		// Update a given show
		$scope.updateMovie = function(movie) {
			$http.put('/api/metadata/movies/' + movie.id, movie);
		};


	}]);
})();