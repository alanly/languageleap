/**
 * Create the application instance.
 */
var rankingQuizApp = angular.module('rankingQuizApp', ['ui.bootstrap']);

/**
 * Configure basic request parameters.
 */
rankingQuizApp.run(function($http)
{
	$http.defaults.xsrfCookieName = 'CSRF-TOKEN';
	$http.defaults.xsrfHeaderName = 'X-CSRF-TOKEN';
	$http.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
});

/**
 * Define the controller for the application interface.
 */
rankingQuizApp.controller('RankingQuizController', function($scope, $http, $modal)
{
		// Contain the questions in our quiz.
		$scope.questions = [];


		/**
		 * Retrieve the questions from the backend.
		 */
		$http.get('/rank/quiz').
			success(function(data)
			{
				if (data.status !== 'success')
				{
					alert('An error occurred while attempting to load the quiz.');
					console.error(data);
					return;
				}

				// Store the array of questions.
				$scope.questions = data.data.questions;
			}).
			error(function(data)
			{
				var errorMessage = 'An error occurred while attempting to load the quiz.';
				alert(errorMessage); console.log(errorMessage);

				if ( (data == undefined) || (data.status == undefined) ) return;

				console.error(data);
			});


		/**
		 * Handle the submit button press.
		 */
		$scope.submit = function()
		{
			// Make sure that each question has a selection.
			var hasMissed = false;

			$scope.questions.forEach(function(question)
			{
				if (question.selected == undefined)
				{
					$('#question-'+question.id).addClass('bg-warning');
					hasMissed = true;
				}
				else
				{
					$('#question-'+question.id).removeClass('bg-warning');
				}
			});

			// Show the user the error, and do not proceed.
			if (hasMissed) return alert('Oops, you missed one or more questions!');

			$http.post('/rank/quiz', {'questions': $scope.questions}).
				success(function(data)
				{
					if (data.status !== 'success')
					{
						alert('An error occurred while attempting to load the quiz.');
						console.error(data);
						return;
					}

					console.log(data.data);

					// Open the result modal.
					var modal = $modal.open(
					{
						templateUrl: 'ResultModalTemplate.html',
						controller: 'ResultModalController',
						size: 'md',
						resolve: {
							level: function(){ return data.data.level; },
							redirect: function(){ return data.data.redirect; }
						}
					});
				}).
				error(function(data)
				{
					var errorMessage = 'An error occurred while attempting to submit the quiz.';
					alert(errorMessage); console.log(errorMessage);

					if ( (data == undefined) || (data.status == undefined) ) return;

					console.error(data);
				});
		};
});


rankingQuizApp.controller('ResultModalController', function($scope, $modalInstance, level, redirect)
{
	$scope.level = level;
	$scope.redirect = redirect;
});