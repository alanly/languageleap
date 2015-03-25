(function() {

	var app = angular.module('adminApp');

	app.config(['$routeProvider', function($routeProvider) {

		// Set-up the routes
		$routeProvider

			.when('/movies',
			{
				templateUrl: 'admin/pages/manage-movies',
				controller: 'MovieController'
			})

			.when('/commercials',
			{
				templateUrl: 'admin/pages/manage-commercials',
				controller: 'CommercialController'
			})

			.when('/shows',
			{
				templateUrl: 'admin/pages/manage-shows',
				controller: 'ShowController'
			})
			.when('/quizzes',
			{
				templateUrl: 'admin/pages/manage-quizzes',
				controller: 'QuizzesController'
			})
			.when('/users',
			{
				templateUrl: 'admin/pages/manage-users',
				controller: 'UserController'
			});

	}]);
	
})();