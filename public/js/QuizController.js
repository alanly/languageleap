/**
 * Instantiate the QuizApp instance.
 */
var quizApp = angular.module('quizApp', ['ui.bootstrap', 'ngDragDrop']);

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

	//Get the redirect link for after the quiz
	var redirect = $scope.redirect = JSON.parse(localStorage.getItem("redirect"));

	/**
	 * Load questions from the API on boot.
	 */
	$http.post(
		'/api/quiz',
		{
			'quiz_id': quizInfo.quiz_id
		}
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

			// Activate the first question in the array.
			$scope.questions[0].active = true;
			$scope.currentQuestionIndex = 0;
			
			setTimeout(function()
			{
				if($scope.questions[0].type == "dragAndDrop")
				{
					formatDragAndDrop();
				}
			}, 100);
		}).
		error(function(data, status, headers, config)
		{
			$window.alert('An error occured while attempting to load the quiz. Please return and try again.');
			return console.error(data);
		});
	
	
	$scope.multiplechoice = function(selection)
	{
		// Retrieve the actual form selection.
		selection = angular.copy(selection);

		if (! selection)
		{
			return console.error('Form was submitted without selection.');
		}
		
		// Reference the current question.
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];
		
		putAnswer(selection.answer_id, function(data, status, headers, config)
		{
			var isCorrect = data.data.is_correct;

			if (isCorrect === true)
			{
				// Increment our counter.
				$scope.correctQuestionsCount++;
			}

			// Highlight the selection appropriately.
			$('#selection-id-'+currentQuestion.id+'-'+selection.answer_id).
				addClass('has-' + (isCorrect === true ? 'success' : 'error'));

			// Disable the form's radio buttons.
			$('#form-question-id-'+currentQuestion.id+' input').prop('disabled', true);

			// Enable the "Next Question" button and modify its colouring
			$('#btn-next-'+currentQuestion.id).addClass('btn-success');
			$('#btn-next-'+currentQuestion.id).prop('disabled', false);
		});
	};

	$scope.drag = function(event, ui)
	{
		// Reference the current question.
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];
		var answer_id = ui.draggable.attr("data-word-id");
		
		putAnswer(answer_id, function(data, status, headers, config)
		{
			var isCorrect = data.data.is_correct;

			if (isCorrect === true)
			{
				// Increment our counter.
				$scope.correctQuestionsCount++;
			}

			// Highlight the selection appropriately.
			$('#selection-id-'+currentQuestion.id+'-'+answer_id).find('.btn').
				addClass('btn-' + (isCorrect === true ? 'success' : 'danger')).removeClass('btn-primary');

			// Enable the "Next Question" button and modify its colouring
			$('#btn-next-'+currentQuestion.id).addClass('btn-success');
			$('#btn-next-'+currentQuestion.id).prop('disabled', false);
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
		
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];
		currentQuestion.active = true;
		
		if(currentQuestion.type == "dragAndDrop")
		{
			formatDragAndDrop();
		}
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
				redirect: function() { return $scope.redirect.redirect; }
			},
			backdrop: 'static',
			keyboard: false
		});
	};
	
	function putAnswer(answer_id, success)
	{
		// Reference the current question.
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];
	
		// Send the request to the API and fetch the result.
		$http.put(
			'/api/quiz',
			{
				'quiz_id': $scope.quizID,
				'videoquestion_id': currentQuestion.id,
				'selected_id': answer_id
			}
		).
			success(success).
			error(function(data, status, headers, config)
			{
				return console.error(data);
			});
			
		if (currentQuestion.active !== true)
		{
			return console.error('Form was submitted against an inactive question.');
		}
	}
	
	function formatDragAndDrop()
	{
		// Reference the current question.
		var currentQuestion = $scope.questions[$scope.currentQuestionIndex];
		
		var header = $("#form-question-id-" + currentQuestion.id).find("h3");
		var text = header.text().replace("**BLANK**", '<div></div>');
		header.html(text);
		
		$("#form-question-id-" + currentQuestion.id).find(".droppable").detach().appendTo(header.find("div")).unwrap();
	}
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
			// Ensure we only have 2 decimal places.
			var score = (correctQuestionsCount / questionsCount) * 100;
			score = Math.round(score * 100) / 100

			return score;
		};


		$scope.levelUp = function()
		{
			$.ajax(
			{
				type: 'GET',
				url: "/api/metadata/levelProgress",
				data: {
					_method: "PATCH"
				},
				success: function(data)
				{
					return data.message;
				},
				error: function(data)
				{
					sconsole.log(data);
				},
			});
		};

	}
);
