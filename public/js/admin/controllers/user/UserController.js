(function() {

	var app = angular.module('adminApp');


	app.controller('UserController', ['$scope', '$log', '$http', function($scope, $log, $http) {

		$scope.users = [];

		// Load all of the users
		$http.get('/api/users').
			success(function(data) {
				//get the users from the server and set it.
				$scope.users = data.data;
			}
		);

		// Publish checkbox handler
		$scope.onActiveClick = function($event, user) {
			user.is_active = $event.target.checked;
			$scope.updateUser(user);
		};

		// Update a given user
		$scope.updateUser = function(user) {
			$http.post('/admin/user/', {
				user_id : user.id
			});
		};
		
	}]);
})();