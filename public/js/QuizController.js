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

	// Hold the current question's ID
	var currentQuestion = $scope.currentQuestion = -1;

	// Hold the current quiz ID
	var currentQuizID = $scope.currentQuizID = -1;

	// Hold the current selection
	var selection = $scope.selection = {};

	// Function simply appends the specified question object to the collection.
	$scope.appendQuestion = function(question)
	{
		currentQuestion = question;
		questions.push(question);
	};

	// Function to handle submitting an answer for a question on the quiz.
	$scope.submit = function(formSelection)
	{
		selection = angular.copy(formSelection);

		$http.post(
			'/api/quiz',
			{
				'quiz_id': currentQuizID,
				'question_id': currentQuestion.id,
				'selection_id': selection.selection_id
			}
		).success(function(response)
		{
			$scope.appendQuestion(response.data.question);
		}).error(function(response)
		{
			console.log('an error occured while submitting the selection.');
		});
	};

	// Fetch the initial question at boot.
	$http.get('/api/quiz').success(function(response)
	{
		currentQuizID = response.data.quiz_id;
		$scope.appendQuestion(response.data.question);
	});
});