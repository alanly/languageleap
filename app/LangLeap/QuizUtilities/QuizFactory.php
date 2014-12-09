<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;

/**
 * Factory that creates quizzes based on selected words in a script
 *
 * @author Quang Tran <tran.quang@live.com>
 */
 class QuizFactory {
 
	private static $instance;
	
	public static function getInstance()
	{
		if(QuizFactory::$instance == null)
		{
			QuizFactory::$instance = new QuizFactory();
		}
		return QuizFactory::$instance;
	}
	
	public function getDefinitionQuiz(Collection $scriptDefinitions, $selectedDefinitions)
	{
		throw new \Exception("Not implemented");
	}
	
	public function getCustomQuiz()
	{
		throw new \Exception("Not implemented");
	}
 }