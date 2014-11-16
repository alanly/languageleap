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
 * Define our QuizController.
 */
quizApp.controller('QuizController', function($scope, $http, $modal, $window)
{
	// Contains all the questions in the quiz.
	var questions = $scope.questions = [];

	var correctQuestionsCount = $scope.correctQuestionsCount = 0;

	// Hold the current question object
	var currentQuestion = $scope.currentQuestion = {};

	// Hold the current quiz ID
	var currentQuizID = $scope.currentQuizID = -1;

	// Hold the current form selection.
	var selection = $scope.selection = {};

	// Hold the destination URL to redirect to after the quiz
	var redirectUrl = $scope.redirectUrl = '';

	// Function simply appends the specified question object to the collection.
	$scope.appendQuestion = function(question)
	{
		if (question.last === true)
		{
			$('.btn-next').addClass('hide');
			$('.btn-score-open').removeClass('hide');
		}

		questions.push(question);
	};

	// Function to handle submitting an answer for a question on the quiz.
	$scope.submit = function(formSelection)
	{
		selection = angular.copy(formSelection);

		if (! selection)
		{
			return console.log('no selection was made');
		}

		$http.post(
			'/api/quiz',
			{
				'quiz_id': currentQuizID,
				'question_id': currentQuestion.id,
				'selection_id': selection.definition_id
			}
		).success(function(response)
		{
			var previous = response.data.previous;
			var question = response.data.question;
			var result   = response.data.result;

			// Add question to collection.
			if (question !== undefined)
			{
				$scope.appendQuestion(response.data.question);
			}

			if (result !== undefined)
			{
				$scope.redirectUrl = result.redirect;
			}

			// Highlight the wrong answer
			if (previous.result === false)
			{
				$('#radio-selection-id-'+previous.selected).addClass('has-error');	
			}

			// Highlight the correct answer
			$('#radio-selection-id-'+previous.answer).addClass('has-success');

			if (previous.result === true)
			{
				correctQuestionsCount++;
			}

			// Disable radio buttons
			$('#form-question-id-'+currentQuestion.id+' input').prop('disabled', true);

			// Enable the "Next Question" button and modify its colouring
			$('#btn-next-'+currentQuestion.id).addClass('btn-success');
			$('#btn-next-'+currentQuestion.id).prop('disabled', false);

			if (currentQuestion.last === true)
			{
				$('.btn-score-open').prop('disabled', false)
			}
		}).error(function(response)
		{
			$('#btn-submit-'+currentQuestion.id).removeClass('btn-warning').addClass('btn-error');
			console.log('an error occured while submitting the selection.');
			console.log(response);
		});
	};

	$scope.nextQuestion = function()
	{
		if (currentQuestion.last === true)
		{
			return $scope.openScore();
		}

		var questionIndex = questions.indexOf(currentQuestion) + 1;

		if (questionIndex >= questions.length) return;

		// Disable current question
		currentQuestion.active = false;

		// Increment current question pointer
		currentQuestion = questions[questionIndex];

		// Enable new question
		currentQuestion.active = true;
	};

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
				redirect: function() { return $scope.redirectUrl; }
			}
		});
	};

	// Fetch the initial question at boot.
	$http.get('/api/quiz').success(function(response)
	{
		var question = response.data.question;

		if (question === undefined)
		{
			redirectUrl = response.data.result.redirect;

			if (redirectUrl === undefined)
			{
				$window.alert('An error occurred while loading this quiz. Please notify an administrator.');
			}

			return $window.location = redirectUrl;
		}

		currentQuizID = response.data.quiz_id;

		currentQuestion = question;
		currentQuestion.active = true;

		$scope.appendQuestion(question);
	});
});

quizApp.controller('ScoreModalInstanceController', function($scope, $modalInstance, correctQuestionsCount, questionsCount, redirect)
{

	$scope.correctQuestionsCount = correctQuestionsCount;
	$scope.questionsCount = questionsCount;
	$scope.redirect = redirect;

	$scope.finalScore = function()
	{
		return (correctQuestionsCount / questionsCount) * 100;
	};

});