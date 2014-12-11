<?php

use LangLeap\Quizzes\Question;
use LangLeap\Videos\Video;
use LangLeap\Quizzes\VideoQuestion;	
use LangLeap\Words\Definition;
use LangLeap\Quizzes\Quiz;

class VideoQuestionTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('videoquestion')->delete();
		$videoquestion = App::make('LangLeap\Quizzes\VideoQuestion');
		
		$quiz = Quiz::first()->id;
		$videoquestion->create(["question_id" => 1, "quiz_id" => $quiz, "is_custom" => false]);
		$videoquestion->create(["question_id" => 2, "quiz_id" => $quiz, "is_custom" => false]);
		$videoquestion->create(["question_id" => 3, "quiz_id" => $quiz, "is_custom" => false]);
	}
}
