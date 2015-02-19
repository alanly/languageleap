<?php namespace LangLeap\QuestionUtilities;

use LangLeap\Quizzes\Answer;
use LangLeap\Questions\Question;
use LangLeap\Questions\CustomQuestion;
use LangLeap\Questions\DragAndDropQuestion;
use LangLeap\Questions\DefinitionQuestion;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\WordUtilities\WordInformation;
use LangLeap\Words\Script;


/**
 * Factory that creates quizzes based on selected words in a script
 *
 * @author Dror Ozgaon 	<dror.ozgaon@gmail.com>
 */
class QuestionFactory
{
	private static $instance;
	
	public static function getInstance()
	{
		if (QuestionFactory::$instance == null)
		{
			QuestionFactory::$instance = new QuestionFactory();
		}

		return QuestionFactory::$instance;
	}
	
	/**
	 * Return a DefinitionQuestion
	 *
	 * @param  string  $questionPrepend
	 * @param  string  $wordInformation
	 * @return Question
	 */
	public function getDefinitionQuestion($questionPrepend, $wordInformation)
	{
		$definitionQuestion = DefinitionQuestion::create([
			'question' => $questionPrepend . $wordInformation->getWord() . '?',
			'word' => strtolower($wordInformation->getWord()),
		]);

		// Create a new Question instance
		$question = Question::create([
			'answer_id' 		=> -1, // Will be changed after the answer is generated
			'question_type'  	=> 'LangLeap\Questions\DefinitionQuestion',
			'question_id'		=> $definitionQuestion->id,
		]);

		return $question;
	}

	/**
	 * Return a DragAndDropQuestion
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function getDragAndDropQuestion($wordInformation)
	{
		$definitionQuestion = DragAndDropQuestion::create([
			'sentence' => $wordInformation->getSentence()
		]);

		// Create a new Question instance
		$question = Question::create([
			'answer_id' 		=> -1, // Will be changed after the answer is generated
			'question_type'  	=> 'LangLeap\Questions\DragAndDropQuestion',
			'question_id'		=> $definitionQuestion->id,
		]);

		return $question;
	}
}
