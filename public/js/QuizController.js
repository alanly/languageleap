/**
 * Instantiate the QuizApp instance.
 */
var quizApp = angular.module('quizApp', ['ui.bootstrap']);

/**
 * Setup our CSRF-handling values.
 */
quizApp.run(function($http)
{
	$http.defaults.xsrfCookieName = 'CSRF-TOKEN';
	$http.defaults.xsrfHeaderName = 'X-CSRF-TOKEN';
});

/**
 * Define the controller for our quiz interface.
 */
quizApp.controller('QuizController', function($scope, $http, $modal, $window)
{

	// Contain the ID of the ongoing quiz.
	var quizID = $scope.quizID = -1;

	// Contain an array of all the questions.
	var questions = $scope.questions = [];

	// Contain the index of the current question.
	var currentQuestionIndex = $scope.currentQuestionIndex = -1;

	// Contain a count of the number of correctly answered questions.
	var correctQuestionsCount = $scope.correctQuestionsCount = 0;

	// Get the video information from the local storage.
	var quizInfo = $scope.videoInfo = JSON.parse(localStorage.getItem("quizPrerequisites"));
	
	console.log(quizInfo);

	/**
	 * Load questions from the API on boot.
	 */
	$http.get(
		'/api/quiz/' + quizInfo.quiz_id
	).
		success(function(data, status, headers, config)
		{
			// Store the data retrieved.
			$scope.quizID = data.data.id;
			$scope.questions = data.data.video_questions;

			// Ensure that we have data.
			if (! Array.isArray($scope.questions) || $scope.questions.length < 1)
			{
				$window.alert('An error occured while attempting to load the quiz. Please return and try again.');
				return console.error(data);
			}

			console.log(data);

			// Activate the first question in the array.
			$scope.questions[0].active = true;
			$scope.currentQuestionIndex = 0;
		}).
		error(function(data, status, headers, config)
		{
			$window.alert('An error occured while attempting to load the quiz. Please return and try again.');
			return console.error(data);
		});

	$scope.submit = function(selection)
	{
		// Retrieve the actual form selection.
		selection = angular.copy(selection);

		if (! selection)
		{
			return console.error('Form was submitted without selection.');
		}

		// Reference the current question.
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];

		if (currentQuestion.active !== true)
		{
			return console.error('Form was submitted against an inactive question.');
		}

		// Send the request to the API and fetch the result.
		$http.put(
			'/api/quiz',
			{
				'quiz_id': $scope.quizID,
				'videoquestion_id': currentQuestion.id,
				'selected_id': selection.definition_id
			}
		).
			success(function(data, status, headers, config)
			{
				var isCorrect = data.data.is_correct;

				if (isCorrect === true)
				{
					// Increment our counter.
					$scope.correctQuestionsCount++;
				}

				// Highlight the selection appropriately.
				$('#radio-selection-id-'+currentQuestion.id+'-'+selection.definition_id).
					addClass('has-' + (isCorrect === true ? 'success' : 'error'));

				// Disable the form's radio buttons.
				$('#form-question-id-'+currentQuestion.id+' input').prop('disabled', true);

				// Enable the "Next Question" button and modify its colouring
				$('#btn-next-'+currentQuestion.id).addClass('btn-success');
				$('#btn-next-'+currentQuestion.id).prop('disabled', false);
			}).
			error(function(data, status, headers, config)
			{
				return console.error(data);
			});
	};

	/**
	 * Load the proceeding question.
	 * @return void
	 */
	$scope.nextQuestion = function()
	{
		// If there are no more questions, then open the score window.
		if ($scope.currentQuestionIndex === ($scope.questions.length - 1)) return $scope.openScore();

		// Deactivate the current question.
		$scope.questions[$scope.currentQuestionIndex].active = false;

		// "Uncheck" selection
		$('.radio input').prop('checked', false);

		// Increment to the next question.
		$scope.currentQuestionIndex++;
		$scope.questions[$scope.currentQuestionIndex].active = true;
	};

	/**
	 * Open the score-modal dialog.
	 * @return void
	 */
	$scope.openScore = function()
	{
		var modalInstance = $modal.open(
		{
			templateUrl: 'scoreModalTemplate.html',
			controller: 'ScoreModalInstanceController',
			size: 'md',
			resolve: {
				correctQuestionsCount: function() { return $scope.correctQuestionsCount; },
				questionsCount: function() { return $scope.questions.length; },
				redirect: function() { return 'https://www.reddit.com/'; }
			}
		});
	};
	
});

/**
 * Define the controller for our score modal window interface.
 */
quizApp.controller(
	'ScoreModalInstanceController',
	function($scope, $modalInstance, correctQuestionsCount, questionsCount, redirect)
	{

		$scope.correctQuestionsCount = correctQuestionsCount;
		$scope.questionsCount = questionsCount;
		$scope.redirect = redirect;

		$scope.finalScore = function()
		{
			return (correctQuestionsCount / questionsCount) * 100;
		};

	}
);