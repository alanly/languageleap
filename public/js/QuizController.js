/**
 * Instantiate the QuizApp instance.
 */
var quizApp = angular.module('quizApp', []);

/**
 * Change the AngularJS interpolation symbols so that they don't conflict with
 * the Blade templating engine.
 */
quizApp.config(function($interpolateProvider)
{
	$interpolateProvider.startSymbol('{%');
	$interpolateProvider.endSymbol('%}');
});

/**
 * Define our QuizController.
 */
quizApp.controller('QuizController', function($scope, $http)
{
	// Contains all the questions in the quiz.
	$scope.questions = [];

	// Function simply appends the specified question object to the collection.
	$scope.appendQuestion = function(question)
	{
		$scope.questions.push(question);
	};

	// Fetch the initial question at boot.
	$http.get('/api/quiz').success(function(response) {
		$scope.appendQuestion(response.data);
	});
});