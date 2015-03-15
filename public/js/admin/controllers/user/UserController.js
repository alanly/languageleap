(function() {

	var app = angular.module('adminApp');


	app.controller('UserController', ['$scope', '$log', '$routeParams', '$http', function($scope, $log, $routeParams, $http) {

		$scope.users = [];

		// Load all of the users
		$http.get('/api/users').
			success(function(data) {
				//get the users from the server and set it.
				$scope.users = data.data;
			}
		);

		
	}]);
})();