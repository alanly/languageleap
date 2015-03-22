(function() {

	var app = angular.module('adminApp');


	app.controller('QuizzesController', ['$scope', '$log', '$routeParams', '$http', '$modal', function($scope, $log, $routeParams, $http, $modal) {

		$scope.videos = [];
		
		// Load all of the videos
		$http.get('/api/videos').
			success(function(data) {
				//get the videos from the server and set it.
				$scope.videos = data.data;
			}
		);
		
		$scope.openAddModal = function(video) {
			
			var modalInstance = $modal.open({
				templateUrl: 'partials/add-quiz-modal',
				controller: 'AddController',
				size: 'lg',
				resolve : {
					video : function() { return video; }
				},
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};
		
		$scope.openRemoveModal = function(video) {
			
			var modalInstance = $modal.open({
				templateUrl: 'partials/remove-quiz-modal',
				controller: 'RemoveController',
				size: 'lg',
				resolve : {
					video : function() { return video; }
				},
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};
		
	}]);
	
	app.controller('AddController', ['$scope', '$http', '$modalInstance', 'video', function($scope, $http, $modalInstance, video){
		
		$scope.video = angular.copy(video);
		$scope.question = {
			answer: [],
		};

		$scope.storeQuestion = function() {
			
			var formData = new FormData();
			formData.append("video_id", $scope.video.id);
			formData.append("question", $scope.question.question);
			formData.append("answer", $scope.question.answer);
			
			$.ajax({
				type: "PUT",
				url: "/api/quiz/custom-question",
				data: formData,
				cache: false,
				processData: false,
				contentType: false
			})
			.success(function(data, status, xhr) {
					$modalInstance.dismiss('cancel');
			})
			.fail(function(xhr, status, error) {
				console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
			});
		};
		
		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		};
		
	}]);
	
	app.controller('RemoveController', ['$scope', '$http', '$modalInstance', 'video', function($scope, $http, $modalInstance, video){
		
		$scope.video = angular.copy(video);
		$scope.question = {
			answer: [],
		};

		$scope.questions = [];
		
		$http.get('/api/quiz/custom-questions/' + $scope.video.id)
		.success(function(data) {
				//get the questions from the server and set it.
				$scope.questions = data.data;
			}
		);
		
		$scope.remove = function(question) {
			
			$.ajax({
				type: "DELETE",
				url: "/api/quiz/custom-question/" + question.id,
				data: null,
				cache: false,
				processData: false,
				contentType: false
			})
			.success(function(data, status, xhr) {
					var index = $scope.questions.indexOf(question);
					if(index > -1)
					{
						$scope.questions.splice(index, 1);
						$scope.$apply();
					}
					
			})
			.fail(function(xhr, status, error) {
				console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
			});
		};
		
		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		};
		
	}]);
})();

var test;