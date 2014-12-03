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
		DB::table('answers')->delete();
		$result = App::make('LangLeap\Quizzes\Result');

		$result->create(["videoquestion_id" => 1, "is_correct" => false, "user_id" => 1, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 1, "is_correct" => true, "user_id" => 1, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 1, "is_correct" => true, "user_id" => 1, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 4, "is_correct" => true, "user_id" => 1, "timestamp" => date_default_timezone_get()]);
		$result->create(["videoquestion_id" => 5, "is_correct" => false, "user_id" => 1, "timestamp" => date_default_timezone_get()]);
	}
}
