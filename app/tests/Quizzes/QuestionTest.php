<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*		@author Thomas Rahn <thomas@rahn.ca>
*/
class QuestionTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testQuizRelation()
	{
		$question = $this->getQuestionInstance();
		$quiz = $this->getQuizInstance();
		$question->question = '';
		$question->selected_id = 1;
		$question->quiz_id = $quiz->id;
		$question->definition_id = 1;
		$question->save();
	
		$this->assertCount(1, $question->quiz()->get());			
	}
	
	public function testDefinitionRelation()
	{
		$question = $this->getQuestionInstance();
		$definition = $this->getDefinitionInstance();

		$question->question = 'question';
		$question->selected_id = 1;
		$question->quiz_id = 1; //un-needed id;
		$question->definition_id = $definition->id;
		$question->save();

		$this->assertCount(1, $question->definition()->get());

	}
	protected function getQuizInstance()
	{
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$quiz->user_id = 1; // un-needed id
		$quiz->video_id = 1; //un-needed id
		$quiz->save();
		return $quiz;
	}	

	protected function getQuestionInstance()
	{
		return App::make('LangLeap\Quizzes\Question');
	}

	protected function getDefinitionInstance()
	{
		$def = App::make('LangLeap\Words\Definition');
		$def->word = "Test word";
		$def->definition = "This is a definition";
		$def->full_definition = "This is the full definition";
		$def->pronunciation = "T-est W-ord";
		$def->save();
		return $def;
	}
}
