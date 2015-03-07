(function() {

	var app = angular.module('adminApp');

	app.controller('MovieController', ['$scope', '$log', '$routeParams', '$http', function($scope, $log, $routeParams, $http) {

		$scope.movies = [];

		// Load all of the movies
		$http.get('/api/metadata/movies').
			success(function(data) {
				//get the movies from the server and set it.
				$scope.movies = data.data;
			});
		}]);

	

})();