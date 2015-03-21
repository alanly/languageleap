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

		//MEDIA SECTION

		$scope.manageMedia = function(movie) {

			$http.get('/api/metadata/movies/' + movie.id).
			success(function(data){

				$scope.current_movie = data.data;
				$scope.video = $scope.current_movie.videos[0] !== undefined ? $scope.current_movie.videos[0] : {};
				
				//Initializations
				$scope.video.media_type = "movie";
				$scope.video.media_id = $scope.current_movie.id;
				$scope.video.path = $scope.video.path;

				if($scope.video.timestamps_json !== undefined)
				{
					$scope.video.timestamps = angular.fromJson($scope.video.timestamps_json);
				}
				else
				{
					$scope.video.timestamps = [];
				}

				$scope.movie_media = 'partials/movie-media';	
			});
		};

		$scope.saveMedia = function() {
			if($scope.video.id === null)//New video
			{
				$http.post('/api/videos', $scope.video);
			}
			else //Update
			{
				var formData = new FormData();
				formData.append('video', $("#video").prop('files')[0]);
				formData.append('media_id', $scope.current_movie.id);
				formData.append('media_type', $scope.video.media_type);
				formData.append('_method', 'PUT');

				$.ajax({
					type : "POST",
					url : '/api/videos/' + $scope.video.id,
					data : formData,
					cache : false,
					processData : false,
					contentType : false
				})
				.done(function(data, status, xhr){
					$scope.video = data.data;
				})
				.fail(function(xhr, status, error) {
					console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
				});
			}
		};

		//END MEDIA SECTION

		//START TIME STAMPS SECTION

		$scope.addTimestamp = function() {
			$scope.video.timestamps.push({
				'from' : 0, 
				'to' : 0
			});
		}

		$scope.removeTimestamp = function(timestamp) {
			var index = $scope.video.timestamps.indexOf(timestamp);
			$scope.video.timestamps.splice(index, 1);
		}

		$scope.saveTimestamps = function() {
			$scope.video.timestamps_json = angular.toJson($scope.video.timestamps);
			console.log($scope.video.timestamps_json);
			$http.post('/api/videos/timestamps/' + $scope.video.id, {
				'timestamps_json' : $scope.video.timestamps_json
			})
			.success(function(data){
				
			});
		}

		//END TIME STAMP SECTION

		//SCRIPT SECTION

		$scope.setScript = function()
		{
			$scope.video.script = $(".script-editor").html();
		}

		$scope.parseFile = function()
		{
			var formData = new FormData();
			formData.append('script-file', $("#parsable-script").prop('files')[0]);

			$.ajax({
				type : "POST",
				url : '/api/parse/script',
				data : formData,
				cache : false,
				processData : false,
				contentType : false
			})
			.done(function(data, status, xhr){
				$scope.video.script = data.data;
				$(".script-editor").html($scope.video.script);
			})
			.fail(function(xhr, status, error) {
				console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
			});
		}

		//END SCRIPT SECTION

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
