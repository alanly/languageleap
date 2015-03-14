(function() {

	var app = angular.module('adminApp');


	app.controller('MovieController', ['$scope', '$log', '$routeParams', '$http', '$modal', function($scope, $log, $routeParams, $http, $modal) {

		$scope.movies = [];

		var modal_instance;

		$scope.current_movie;

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

		$scope.openEditModal = function(movie) {

			$scope.current_movie = movie;

			var modal_instance = $modal.open({
				templateUrl: 'partials/edit-movie-modal',
				controller: 'EditMovieController',
				size: 'lg',
				resolve : {
					movie : function() { return movie; }
				},
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};

		$scope.openAddModal = function() {

		};

	}]);

	app.controller('EditMovieController', ['$scope', '$http', '$modalInstance', 'movie', function($scope, $http, $modalInstance, movie){

		$scope.movie = movie;

		$scope.saveMovie = function() {
			$http.put('/api/metadata/movies/' + movie.id, $scope.movie)
			.success(function(data){
				$modalInstance.dismiss('cancel');
			});
		}
	}]);

})();