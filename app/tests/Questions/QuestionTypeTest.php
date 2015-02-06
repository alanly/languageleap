<?php namespace LangLeap\Questions;

use LangLeap\TestCase;
use LangLeap\Quizzes\Answer;
use App;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class QuestionTypeTest extends TestCase {

	public function testCustomQuestionRelation()
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

		$this->assertEquals($cq->id, $cq->questionType->first()->question_id);
		$this->assertSame('LangLeap\Questions\CustomQuestion', $cq->questionType->first()->question_type);
	}

	public function testDefinitionQuestionRelation()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$dq = DefinitionQuestion::create(['question' => 'What is the definition of cat?']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DefinitionQuestion';
		$q->question_id = $dq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		$this->assertEquals($dq->id, $dq->questionType->first()->question_id);
		$this->assertSame('LangLeap\Questions\DefinitionQuestion', $dq->questionType->first()->question_type);
	}

	public function testDragAndDropQuestionRelation()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
			Answer::create(['answer' => 'test answer 4']),
		];

		$ddq = DragAndDropQuestion::create(['sentence' => 'The **BLANK** flies above the mountains.']);

		// Create our question.
		$q = new Question();
		$q->question_type = 'LangLeap\Questions\DragAndDropQuestion';
		$q->question_id = $ddq->id;
		$q->answer_id = $a[0]->id;
		$q->save();

		$this->assertEquals($ddq->id, $ddq->questionType->first()->question_id);
		$this->assertSame('LangLeap\Questions\DragAndDropQuestion', $ddq->questionType->first()->question_type);
	}
}
