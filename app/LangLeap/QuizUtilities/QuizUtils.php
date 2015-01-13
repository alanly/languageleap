<?php namespace LangLeap\QuizUtilities;

class QuizUtils {
	
	/**
	 *	Create a quiz based on selected words from a video script
	 *
	 * 	@param User $user
	 *	@param array $input
	 *	@return [$success, $data, $http_status]
	 */
	public static function createVideoQuiz($user, $input)
	{
		$quizDecorator = new QuizCreationValidation(QuizFactory::getInstance());
		return $quizDecorator->response($user, $input);
	}
	
	/**
	 *	Run validation and update the quiz score if validation passes
	 *
	 *	@param User $user
	 *	@param array $input
	 *	@return [$success, $data, $http_status]
	 */
	public static function answerQuizQuestion($user, $input)
	{
		$answerDecorator = new QuizAnswerValidation(new QuizAnswerUpdate());
		return $answerDecorator->response($user, $input);
	}
	
	/**
	 *	Run validation and create a reminder quiz. 
	 *	Contains all of the questions a user has gotten wrong recently.
	 *
	 *	@param User $user
	 *	@param array $input
	 *	@return [$success, $data, $http_status]
	 */
	 public static function createReminderQuiz($user, $input)
	 {
		$quizDecorator = new ReminderQuizValidation(QuizFactory::getInstance());
		return $quizDecorator->response($user, $input);
	 }
}