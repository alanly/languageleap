<?php namespace LangLeap\Questions;

use LangLeap\TestCase;
use LangLeap\Quizzes\Answer;
use App;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class QuestionTest extends TestCase {

	public function testAnswersRelationshipFunctionWorksCustomQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$cq = CustomQuestion::create(['question' => 'What year is it?']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\CustomQuestion';
		$q->question_id = $cq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertCount(count($a), $q->answers);
	}

	public function testAnswersRelationshipFunctionWorksDefinitionQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$dq = DefinitionQuestion::create(['question' => 'What is the definition of dog?', 'word' => 'dog']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DefinitionQuestion';
		$q->question_id = $dq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertCount(count($a), $q->answers);
	}

	public function testAnswersRelationshipFunctionWorksDragAndDropQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$ddq = DragAndDropQuestion::create(['sentence' => 'The **BLANK** went on a walk']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DragAndDropQuestion';
		$q->question_id = $ddq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertCount(count($a), $q->answers);
	}

	public function testAnswerRelationshipFunctionReturnsCorrectAnswerInstanceCustomQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$cq = CustomQuestion::create(['question' => 'What year is it?']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\CustomQuestion';
		$q->question_id = $cq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertSame($a[0]->answer, $q->answer->answer);
	}

	public function testAnswerRelationshipFunctionReturnsCorrectAnswerInstanceDefinitionQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$dq = DefinitionQuestion::create(['question' => 'What is the definition of dog?', 'word' => 'dog']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DefinitionQuestion';
		$q->question_id = $dq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertSame($a[0]->answer, $q->answer->answer);
	}

	public function testAnswerRelationshipFunctionReturnsCorrectAnswerInstanceDragAndDropQuestion()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$ddq = DragAndDropQuestion::create(['sentence' => 'The **BLANK** went on a walk']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DragAndDropQuestion';
		$q->question_id = $ddq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertSame($a[0]->answer, $q->answer->answer);
	}
}
