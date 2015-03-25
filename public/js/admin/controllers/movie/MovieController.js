(function() {

	var app = angular.module('adminApp');


	app.controller('MovieController', ['$scope', '$log', '$routeParams', '$http', '$modal', '$timeout', function($scope, $log, $routeParams, $http, $modal, $timeout) {

		$scope.movies = [];

		var modal_instance;

		$scope.current_movie;
		$scope.media_type = "movie";

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
				templateUrl: 'admin/partials/edit-movie-modal',
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
				templateUrl: 'admin/partials/new-movie-modal',
				controller: 'NewMovieController',
				resolve : {
					media_type : function() { return $scope.media_type }
				},
				size: 'lg',
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};

		//MEDIA SECTION

		$scope.manageMedia = function(movie) {
			$scope.movie_media = 'admin/partials/movie-media';	
			
			$http.get('/api/metadata/movies/' + movie.id).
			success(function(data){

				$scope.current_movie = data.data;
				$scope.video = $scope.current_movie.videos[0] !== undefined ? $scope.current_movie.videos[0] : {};
				
				//Initializations
				$scope.video.media_id = $scope.current_movie.id;
				$scope.video.path = $scope.video.path;
				$scope.video.script_text = $scope.video.script.text;
				$(".script-editor").html($scope.video.script_text);
				
				if($scope.video.timestamps_json !== null)
				{
					$scope.video.timestamps = angular.fromJson($scope.video.timestamps_json);
				}
				else
				{
					$scope.video.timestamps = [];
				}
				
				$scope.isActive = $scope.video.path == null;
			});
		};

		$scope.saveMedia = function() {
			var formData = new FormData();
			var file = $("#video").prop('files')[0];

			if(file !== undefined) {
				formData.append('video', file);
			}

			formData.append('media_id', $scope.current_movie.id);
			formData.append('media_type', $scope.media_type);
			formData.append('script', $scope.video.script_text);
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
				$("#admin-player").get(0).load();
				$("#video-view").find("a").click();
				$("#file-input-form")[0].reset();
				$scope.savedMedia();
			})
			.fail(function(xhr, status, error) {
				console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
			});
		};

		//END MEDIA SECTION

		//START TIME STAMPS SECTION

		$scope.addTimestamp = function() {
			var from = 0;
			var to = 1;
			
			if($scope.video.timestamps == undefined)
			{
				$scope.video.timestamps	= [];
			}

			if($scope.video.timestamps.length > 0)
			{
				from = $scope.video.timestamps[$scope.video.timestamps.length - 1].to;
				to = from;
				if(! isNaN(from))
				{
					to = parseInt(from) + 1;
				}
			}
			
			$scope.video.timestamps.push({
				'from' : from, 
				'to' : to
			});
		}

		$scope.removeTimestamp = function(timestamp) {
			var index = $scope.video.timestamps.indexOf(timestamp);
			$scope.video.timestamps.splice(index, 1);
		}

		$scope.saveTimestamps = function() {
			$scope.video.timestamps_json = angular.toJson($scope.video.timestamps);

			$http.post('/api/videos/timestamps/' + $scope.video.id, {
				'timestamps_json' : $scope.video.timestamps_json
			})
			.success(function(data){
				$scope.savedMedia();
			});
		}

		//END TIME STAMP SECTION

		//SCRIPT SECTION

		$scope.setScript = function()
		{
			$scope.video.script_text = $(".script-editor").html();
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
				$scope.video.script_text = data.data;
				$(".script-editor").html($scope.video.script_text);
			})
			.fail(function(xhr, status, error) {
				console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
			});
		}

		//END SCRIPT SECTION


		$scope.savedMedia = function()
		{
			$scope.saved = true;
			$timeout(function(){
				$scope.saved = false;
			}, 5000)
		}
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

	app.controller('NewMovieController', ['$scope', '$http', '$modalInstance','$rootScope', 'media_type', function($scope, $http, $modalInstance, $rootScope, media_type){

		$scope.movie = {};
		$scope.media_type = media_type
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

				$scope.addVideo(data.data);
				
			});
			
		}

		$scope.addVideo = function(movie){

			var newVideoData = new FormData();
			newVideoData.append('media_type', 'movie');
			newVideoData.append('media_id', movie.id);
			newVideoData.append('script', 'Placeholder');
			
			$.ajax({
				type : "POST",
				url: "/api/videos",
				data: newVideoData,
				processData: false,
				contentType: false,
				cache: false,
				success : function(data){

				}
			});
		}

		$scope.closeModel = function() {
			$modalInstance.dismiss('cancel');
		}

	}]);
})();
