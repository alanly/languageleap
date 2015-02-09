<?php namespace LangLeap\Questions;

use LangLeap\TestCase;
use LangLeap\QuestionUtilities\QuestionFactory;
use LangLeap\WordUtilities\WordInformation;
use LangLeap\Videos\Video;


class QuestionFactoryTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	public function testDefinitionQuestionReturned()
	{
		$word = 'cat';
		$questionPrepend = 'What is the definition of ';
		$wordInformation = new WordInformation($word, 'vicious, animal', 'the cat is annoying', Video::first()->id);
		$question = QuestionFactory::getInstance()->getDefinitionQuestion($questionPrepend, $wordInformation);

		$this->assertNotNull($question);

		$definitionQuestion = DefinitionQuestion::find($question->question_id);
		$this->assertNotNull($definitionQuestion);

		$this->assertEquals($definitionQuestion->id, $question->question_id);
	}

	public function testDragAndDropQuestionReturned()
	{
		$word = 'cat';
		$sentence = 'the cat is annoying catnip';
		$wordInformation = new WordInformation($word, 'vicious, animal', $sentence, Video::first()->id);
		$question = QuestionFactory::getInstance()->getDragAndDropQuestion($wordInformation);

		$this->assertNotNull($question);

		$dragDropQuestion = DragAndDropQuestion::find($question->question_id);
		$this->assertNotNull($dragDropQuestion);

		$this->assertEquals($dragDropQuestion->id, $question->question_id);
	}
	
}
