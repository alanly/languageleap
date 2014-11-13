<?php

use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
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

		$quiz = Quiz::first();
		$def = Definition::first();
		$quiz->questions()->create(["definition_id" => $def->id, "question" => "What is the definition for" . $def->word]);
	}
}
