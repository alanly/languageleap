<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class QuestionTest extends TestCase {

	/*public function testAnswersRelationshipFunctionWorks()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
		];

		// Create our question.
		$q = new Question(['question' => 'test question']);
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertCount(count($a), $q->answers);
	}


	public function testAnswerRelationshipFunctionReturnsCorrectAnswerInstance()
	{
		// Create a series of answers.
		$a = [
			Answer::create(['answer' => 'test answer 1']),
			Answer::create(['answer' => 'test answer 2']),
			Answer::create(['answer' => 'test answer 3']),
		];

		// Create our question.
		$q = new Question(['question' => 'test question']);
		$q->answer_id = $a[0]->id;
		$q->save();

		// Save the associated answers.
		$q->answers()->saveMany($a);

		$this->assertSame($a[0]->answer, $q->answer->answer);
	}*/

}
