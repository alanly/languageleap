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

		$scope.manageMedia = function(movie) {

			$http.get('/api/metadata/movies/' + movie.id).
			success(function(data){

				$scope.current_movie = data.data;
				$scope.video = $scope.current_movie.videos[0] !== undefined ? $scope.current_movie.videos[0] : {};
				
				$scope.video.media_type = "movie";
				$scope.video.media_id = $scope.current_movie.id;
				$scope.video.script = "";
				$scope.video.timestamps = [];

				$scope.movie_media = 'partials/movie-media';	
			});
		};

		$scope.addTimestamp = function() {
			$scope.video.timestamps.push({
				'start' : 0, 
				'end' : 0
			});
		}

		$scope.removeTimestamp = function(timestamp) {
			var index = $scope.video.timestamps.indexOf(timestamp);
			$scope.video.timestamps.splice(index, 1);
		}
		$scope.saveMedia = function() {
			$http.post('/api/videos', $scope.video);
		};
	}]);

	app.controller('EditMovieController', ['$scope', '$http', '$modalInstance', 'movie', function($scope, $http, $modalInstance, movie){

		$scope.movie = angular.copy(movie);

		$scope.saveMovie = function() {

			$http.put('/api/metadata/movies/' + movie.id, $scope.movie)
			.success(function(data){

				var formData = new FormData();
				formData.append("media_image", $("#media_image").prop('files')[0]);
				formData.append("_method", "PUT");

				$.ajax({
					type: "POST",
					url: "/api/metadata/movies/"+data.data.id,
					data: formData,
					cache: false,
					processData: false,
					contentType: false
				})
				.done(function(data, status, xhr) {
					movie.image_path = data.data.image_path;
					angular.copy($scope.movie, movie)
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

	app.controller('NewMovieController', ['$scope', '$http', '$modalInstance','$rootScope', function($scope, $http, $modalInstance, $rootScope){

		$scope.movie = {};

		$scope.storeMovie = function() {

			$http.post('/api/metadata/movies/', $scope.movie)
			.success(function(data){
				var formData = new FormData();
				formData.append("media_image", $("#media_image").prop('files')[0]);
				formData.append("_method", "PUT");

				$.ajax({
					type: "POST",
					url: "/api/metadata/movies/"+data.data.id,
					data: formData,
					cache: false,
					processData: false,
					contentType: false
				})
				.done(function(newMovie, status, xhr) {
					$rootScope.$broadcast('addMovie', newMovie.data);
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
