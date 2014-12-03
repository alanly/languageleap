<?php

use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Words\Definition;

class AnswerTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('answers')->delete();
		$answer = App::make('LangLeap\Quizzes\Answer');
		
		$answer->create(["answer" => "ABC", "question_id" => 1]);
		$answer->create(["answer" => "DEF", "question_id" => 1]);
		$answer->create(["answer" => "GHI", "question_id" => 1]);
		$answer->create(["answer" => "DEF", "question_id" => 2]);
		$answer->create(["answer" => "GHI", "question_id" => 3]);
	}
}
