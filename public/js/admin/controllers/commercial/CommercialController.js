(function() {

	var app = angular.module('adminApp');


	app.controller('CommercialController', ['$scope', '$log', '$routeParams', '$http', '$modal', function($scope, $log, $routeParams, $http, $modal) {

		$scope.commercials = [];

		var modal_instance;

		$scope.current_commercial;

		// Load all of the commercials
		$http.get('/api/metadata/commercials').
			success(function(data) {
				//get the commercials from the server and set it.
				$scope.commercials = data.data;
			}
		);

		$scope.$on('addcommercial', function(event, commercial){
			$scope.commercials.push(commercial);
		});
		
		$scope.remove = function(commercial){
			
			$http.delete('/api/metadata/commercials/' + commercial.id);

			var index = $scope.commercials.indexOf(commercial);
			$scope.commercials.splice(index, 1);

		};

		// Publish checkbox handler
		$scope.onPublishClick = function($event, commercial) {
			commercial.is_published = $event.target.checked;
			$scope.updatecommercial(commercial);
		};

		// Update a given show
		$scope.updatecommercial = function(commercial) {
			$http.put('/api/metadata/commercials/' + commercial.id, commercial);
		};

		$scope.openEditModal = function(commercial) {

			$scope.current_commercial = commercial;

			var modal_instance = $modal.open({
				templateUrl: 'partials/edit-commercial-modal',
				controller: 'EditCommercialController',
				size: 'lg',
				resolve : {
					commercial : function() { return commercial; }
				},
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};

		$scope.openAddModal = function() {
			var modal_instance = $modal.open({
				templateUrl: 'partials/new-commercial-modal',
				controller: 'NewCommercialController',
				size: 'lg',
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};

	}]);

	app.controller('EditCommercialController', ['$scope', '$http', '$modalInstance', 'commercial', function($scope, $http, $modalInstance, commercial){

		$scope.commercial = angular.copy(commercial);

		$scope.saveCommercial = function() {
			$http.put('/api/metadata/commercials/' + commercial.id, $scope.commercial)
			.success(function(data){
				angular.copy($scope.movie, movie)
				$modalInstance.dismiss('cancel');
			});
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}
	}]);

	app.controller('NewCommercialController', ['$scope', '$http', '$modalInstance','$rootScope', function($scope, $http, $modalInstance, $rootScope){

		$scope.commercial = {};

		$scope.storeCommercial = function() {
			
			$http.post('/api/metadata/commercials/', $scope.commercial)
			.success(function(data){
				$rootScope.$broadcast('addcommercial', data.data);
				$modalInstance.dismiss('cancel');
			});
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}
	}]);

})();
