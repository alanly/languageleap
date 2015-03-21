(function() {

	var app = angular.module('adminApp', ['ngRoute', 'ngResource', 'ui.bootstrap']);

	app.run(function($http) {
		$http.defaults.xsrfCookieName = 'CSRF-TOKEN';
		$http.defaults.xsrfHeaderName = 'X-CSRF-TOKEN';
	});
	
})();