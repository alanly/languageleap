(function() {

	var app = angular.module('adminApp');


	app.controller('CommercialController', ['$scope', '$log', '$routeParams', '$http', '$modal', '$timeout', function($scope, $log, $routeParams, $http, $modal, $timeout) {

		$scope.commercials = [];
		$scope.media_type = "commercial";
		var modal_instance;

		$scope.current_commercial;
		$scope.media_type = "commercial";

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
				resolve : {
					media_type : function() { return $scope.media_type; }
				},
				backdrop : 'static',
				backdropClass: 'modal-backdrop-fix'
			});
		};
			//MEDIA SECTION

		$scope.manageMedia = function(commercial) {
			$scope.commercial_media = 'admin/partials/commercial-media';	
			
			$http.get('/api/metadata/commercials/' + commercial.id).
			success(function(data){

				$scope.current_commercial = data.data;
				$scope.video = $scope.current_commercial.videos[0] !== undefined ? $scope.current_commercial.videos[0] : {};
				
				//Initializations
				$scope.video.media_id = $scope.current_commercial.id;
				$scope.video.path = $scope.video.path;
				$scope.video.script_text = $scope.video.script.text;
				$(".script-editor").html($scope.video.script_text);

				// If a script is loaded that does not have a br tag
				// at the end, if the user places the cursor at the end of
				// the content, he will need to press enter twice to get a line-break.
				// This fixes that issue.
				var scriptEditor = $('.script-editor');
				var lastChild = $('.script-editor').children().last();

				if (lastChild.prop('tagName') == 'BR') {
					if (lastChild[0].nextSibling != null && lastChild[0].nextSibling.nodeValue.trim() != '')
						$('.script-editor').append('<br>');
				} else {
					$('.script-editor').append('<br>');
				}

				// Make sure that tooltips are added to existing spans
				refreshTooltips(); // Function from admin-script.js

				loadDefinitions(); // Function from admin-script.js
				
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
			// The anonymous function gets called once all of the
			// definitions have been saved
			saveDefinitions($scope.video.script.id, function() {
				var formData = new FormData();
				var file = $("#video").prop('files')[0];

				if(file !== undefined) {
					formData.append('video', file);
				}

				// Some sanitization of the script before saving to the database
				removeTooltips(); // Function from admin-script.js

				formData.append('media_id', $scope.current_commercial.id);
				formData.append('media_type', $scope.media_type);

				// Need to take the data directly from the script editor because
				// angular doesn't easily bind to content-editable divs
				formData.append('script', $(".script-editor").html());
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
				})
				.fail(function(xhr, status, error) {
					console.log("Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>");
				});
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

	app.controller('NewCommercialController', ['$scope', '$http', '$modalInstance','$rootScope', 'media_type', function($scope, $http, $modalInstance, $rootScope, media_type){

		$scope.commercial = {};
		$scope.media_type = media_type;
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
			
				$scope.addVideo(data.data);
			});
		}

		$scope.addVideo = function(commercial){

			var newVideoData = new FormData();
			newVideoData.append('media_type', 'commercial');
			newVideoData.append('media_id', commercial.id);
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
