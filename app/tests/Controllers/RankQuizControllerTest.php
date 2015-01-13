<?php

use LangLeap\TestCase;
use LangLeap\Levels\Level;

/**
 * @author KC Wan
 * @author Alan Ly <hello@alan.ly>
 */
class RankQuizTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		$this->seed();
	}


	public function testRetrievingTheIndexAsAnUnauthenticatedUserFails()
	{
		Route::enableFilters();

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertRedirectedTo('/login');
		$this->assertSessionHas('action.failed', true);
	}


	public function testRetrievingTheIndexAsAnAuthenticatedButRankedUserFails()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = 20;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertRedirectedTo('/');
	}


	public function testRetrievingTheIndexAsAnAuthenticatedAndUnrankedUserWorks()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertResponseOk();
	}


	public function testRetrievingTheQuizNotViaAjaxFails()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getQuiz');

		$this->assertResponseStatus(405);
	}


	public function testRetrievingTheQuizViaAjaxSucceeds()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getQuiz', [], [], [],
			['HTTP_X-Requested-With' => 'XMLHttpRequest']
		);

		$this->assertResponseOk();
	}


	public function testRetrievedQuizIsValid()
	{
		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getQuiz', [], [], [],
			['HTTP_X-Requested-With' => 'XMLHttpRequest']
		);

		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);

		$jsonData = $response->getData();

		$this->assertSame('success', $jsonData->status);
		$this->assertObjectHasAttribute('questions', $jsonData->data);
		$this->assertCount(5, $jsonData->data->questions); // Currently, there are 5 ranking questions.

		// Arbitrarily pick a question.
		$q = $jsonData->data->questions[0];

		$this->assertObjectHasAttribute('id', $q);
		$this->assertObjectHasAttribute('text', $q);
		$this->assertObjectHasAttribute('answers', $q);
		$this->assertCount(4, $q->answers);

		// Arbitrarily pick an answer.
		$a = $q->answers[0];

		$this->assertObjectHasAttribute('id', $a);
		$this->assertObjectHasAttribute('text', $a);
	}


	public function testUserIsRankedAccordinglyToTheQuizAnswers()
	{
		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getQuiz', [], [], [],
			['HTTP_X-Requested-With' => 'XMLHttpRequest']
		);

		$jsonData = $response->getData()->data;
		$questions = $jsonData->questions;

		// Add the appropriate answer to each each question,
		// simulating a user selection.

		for ($i = 0; $i < count($questions); ++$i)
		{
			$q = $questions[$i];
			$q = App::make('LangLeap\Quizzes\Question')->find($q->id);
			$a = $q->answer;

			$questions[$i]->selected = intval($a->id);
		}

		// Submit our "answered questions"
		$response = $this->action('POST', 'RankQuizController@postQuiz', [],
			['questions' => $questions]);

		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('user', $data);
		$this->assertObjectHasAttribute('level', $data);
		$this->assertObjectHasAttribute('redirect', $data);

		$level = $data->level;

		$this->assertEquals(4, $level->id);
	}
	
}
