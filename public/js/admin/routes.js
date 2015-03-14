(function() {

	var app = angular.module('adminApp');

	app.config(['$routeProvider', function($routeProvider) {

		// Set-up the routes
		$routeProvider

			.when('/movies',
			{
				templateUrl: 'pages/manage-movies',
				controller: 'MovieController'
			})

			.when('/commercials',
			{
				templateUrl: 'pages/manage-commercials',
				controller: 'CommercialController'
			})

			.when('/shows',
			{
				templateUrl: 'pages/manage-shows',
				controller: 'ShowController'
			});

	}]);
	
})();