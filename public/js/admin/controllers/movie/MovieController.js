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

		$scope.$on('addMovie', function(event, movie){
			$scope.movies.push(movie);
		});
		
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

		// Update a given movie
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
			var modal_instance = $modal.open({
				templateUrl: 'partials/new-movie-modal',
				controller: 'NewMovieController',
				size: 'lg',
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};

	}]);

	app.controller('EditMovieController', ['$scope', '$http', '$modalInstance', 'movie', function($scope, $http, $modalInstance, movie){

		$scope.movie = angular.copy(movie);

		$scope.saveMovie = function() {
			$http.put('/api/metadata/movies/' + movie.id, $scope.movie)
			.success(function(data){
				angular.copy($scope.movie, movie)
				$modalInstance.dismiss('cancel');
			});
		}

		$scope.uploadFile = function(files) {
			//set the media image to the file that was selected by the user
			$scope.movie.media_image = files[0];
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}
	}]);

	app.controller('NewMovieController', ['$scope', '$http', '$modalInstance','$rootScope', function($scope, $http, $modalInstance, $rootScope){

		$scope.movie = {};

		$scope.storeMovie = function() {

			$http.post('/api/metadata/movies/', $scope.movie)
			.success(function(data){
				var formData = new FormData();
				formData.append("media_image", $("#media_image").prop('files')[0]);

				//var formData = new FormData($('#new-movie-form')[0]);

				formData.append("_method", "PUT");
				xhr = $.ajax({
					type: "POST",
					url: "/api/metadata/movies/"+data.data.id,
					data: formData,
					cache: false,
					processData: false,
					contentType: false,
					xhr: function() {
						myXhr = $.ajaxSettings.xhr();
						
						return myXhr;
					}
					})
					.done(function(data, status, xhr) {
						console.log("Upload complete! Redirecting...");
					})
					.fail(function(xhr, status, error) {
						console.log(xhr);
						console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
					});

				});
			
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}

	}]);

})();
