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

		$scope.$on('addCommercial', function(event, commercial){
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
			$scope.updateCommercial(commercial);
		};

		// Update a given show
		$scope.updateCommercial = function(commercial) {
			$http.put('/api/metadata/commercials/' + commercial.id, commercial);
		};

		$scope.openEditModal = function(commercial) {

			$scope.current_commercial = commercial;

			var modal_instance = $modal.open({
				templateUrl: 'admin/partials/edit-commercial-modal',
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
				templateUrl: 'admin/partials/new-commercial-modal',
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
				var formData = new FormData();
				formData.append("media_image", $("#media_image").prop('files')[0]);
				formData.append("_method", "PUT");

				$.ajax({
					type: "POST",
					url: "/api/metadata/commercials/"+data.data.id,
					data: formData,
					cache: false,
					processData: false,
					contentType: false
				})
				.done(function(data, status, xhr) {
					commercial.image_path = data.data.image_path;
					angular.copy($scope.commercial, commercial)
					$modalInstance.dismiss('cancel');
				})
				.fail(function(xhr, status, error) {
					console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
				});
			
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
				var formData = new FormData();
				formData.append("media_image", $("#media_image").prop('files')[0]);
				formData.append("_method", "PUT");

				$.ajax({
					type: "POST",
					url: "/api/metadata/commercials/"+data.data.id,
					data: formData,
					cache: false,
					processData: false,
					contentType: false
				})
				.done(function(data, status, xhr) {
					$rootScope.$broadcast('addCommercial', data.data);
					$modalInstance.dismiss('cancel');
				})
				.fail(function(xhr, status, error) {
					console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
				});
			
			});
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}
	}]);

})();
