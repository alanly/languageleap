<?php

use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Answer;
use LangLeap\Words\Definition;

class ResultTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('results')->delete();
		$result = App::make('LangLeap\Quizzes\Result');
		$uid = \LangLeap\Accounts\User::first()->id;

		$result->create(["videoquestion_id" => 1, "user_id" => $uid, "is_correct" => false, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 2, "user_id" => $uid, "is_correct" => true, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 3, "user_id" => $uid, "is_correct" => true, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 4, "user_id" => $uid, "is_correct" => true, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 5, "user_id" => $uid, "is_correct" => false, "timestamp" => date_default_timezone_get()]);
	}
}
