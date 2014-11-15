/**
 * Instantiate the QuizApp instance.
 */
var quizApp = angular.module('quizApp', ['ui.bootstrap']);

/**
 * Define our QuizController.
 */
quizApp.controller('QuizController', function($scope, $http)
{
	// Contains all the questions in the quiz.
	var questions = $scope.questions = [];

	// Hold the current question object
	var currentQuestion = $scope.currentQuestion = {};

	// Hold the current quiz ID
	var currentQuizID = $scope.currentQuizID = -1;

	var selection = $scope.selection = {};

	// Function simply appends the specified question object to the collection.
	$scope.appendQuestion = function(question)
	{
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

		$('#btn-submit-'+currentQuestion.id).removeClass('btn-primary').addClass('btn-warning');

		$http.post(
			'/api/quiz',
			{
				'quiz_id': currentQuizID,
				'question_id': currentQuestion.id,
				'selection_id': selection.selection_id
			}
		).success(function(response)
		{
			// Previous data
			var previous = response.data.previous;

			// Add question to collection.
			$scope.appendQuestion(response.data.question);

			if (previous.result === true)
			{
				$('#radio-selection-id-'+previous.selected).addClass('has-success');
			}
			else if (previous.result === false)
			{
				$('#radio-selection-id-'+previous.selected).addClass('has-error');
				$('#radio-selection-id-'+previous.answer).addClass('has-success');
			}


			// Enable the "Next Question" button and modify its colouring
			$('#btn-next-'+currentQuestion.id).addClass('btn-success');
			$('#btn-next-'+currentQuestion.id).prop('disabled', false);

			// Disable the "Submit Answer" button and modify its colouring
			$('#btn-submit-'+currentQuestion.id).removeClass('btn-warning');
			$('#btn-submit-'+currentQuestion.id).prop('disabled', true);
		}).error(function(response)
		{
			$('#btn-submit-'+currentQuestion.id).removeClass('btn-warning').addClass('btn-error');
			console.log('an error occured while submitting the selection.');
		});
	};

	$scope.nextQuestion = function()
	{
		var questionIndex = questions.indexOf(currentQuestion) + 1;

		if (questionIndex >= questions.length) return;

		// Disable current question
		currentQuestion.active = false;

		// Increment current question pointer
		currentQuestion = questions[questionIndex];

		// Enable new question
		currentQuestion.active = true;
	};

	// Fetch the initial question at boot.
	$http.get('/api/quiz').success(function(response)
	{
		currentQuizID = response.data.quiz_id;

		var question = response.data.question;

		currentQuestion = question;
		currentQuestion.active = true;

		$scope.appendQuestion(question);
	});
});