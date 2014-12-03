<?php

use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Words\Definition;
class QuestionTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('questions')->delete();
		$question = App::make('LangLeap\Quizzes\Question');

		$question->create(["question" => "WHAT IS UP?", "answer_id" => 1]);
		$question->create(["question" => "WHAT IS UP2?", "answer_id" => 1]);
		$question->create(["question" => "WHAT IS UP3?", "answer_id" => 2]);
		$question->create(["question" => "WHAT IS UP4?", "answer_id" => 2]);
	}
}
