<?php namespace LangLeap\Words;

use LangLeap\TestCase;

use LangLeap\Accounts\User;
use LangLeap\Videos\Episode;
use LangLeap\Words\Definition;

use App;

class WordBankTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}

	public function testGetUser()
	{
		$user = User::first();

		$bank = $this->createWordBank();
		$bank->user_id = $user->id;
		$bank->media_id = 1;
		$bank->media_type = "LangLeap\Videos\Episode";
		$bank->definition_id = 1;
		$bank->save();

		$this->assertEquals($user->id, $bank->user()->first()->id );
	}

	public function testGetDefinition()
	{
		$def = Definition::first();

		$bank = $this->createWordBank();
		$bank->user_id = 1;
		$bank->media_id = 1;
		$bank->media_type = "LangLeap\Videos\Episode";
		$bank->definition_id = $def->id;
		$bank->save();

		$this->assertEquals($def->id, $bank->definition()->first()->id );
	}

	public function testGetMedia()
	{
		$ep = Episode::first();

		$bank = $this->createWordBank();
		$bank->user_id = 1;
		$bank->media_id = $ep->id;
		$bank->media_type = "LangLeap\Videos\Episode";
		$bank->definition_id = 1;
		$bank->save();

		$this->assertEquals($ep->id, $bank->media()->first()->id );
	}

	protected function createWordBank()
	{
		return App::make('LangLeap\Words\WordBank');
	}
}
