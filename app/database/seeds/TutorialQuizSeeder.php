<?php

use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;

class TutorialQuizSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('questions')->delete();
		$question = App::make('LangLeap\Quizzes\Question');
		
		$question->create(["question" => "What does Language Leap teach?", "answer_id" => 2]);
		$question->create(["question" => "What do you see beside the video?", "answer_id" => 8]);
		$question->create(["question" => "What can you gain by spending more time on Language Leap?", "answer_id" => 12]);
		$question->create(["question" => "How do you learn new words?", "answer_id" => 13]);
		$question->create(["question" => "What do you need to use Language Leap?", "answer_id" => 17]);
		
		DB::table('answers')->delete();
		$answer = App::make('LangLeap\Quizzes\Answer');
		
		$answer->create(["answer" => "French", "question_id" => 1]);
		$answer->create(["answer" => "English", "question_id" => 1]);
		$answer->create(["answer" => "Spanish", "question_id" => 1]);
		$answer->create(["answer" => "Games", "question_id" => 1]);
		
		$answer->create(["answer" => "Another Video", "question_id" => 2]);
		$answer->create(["answer" => "Nothing at all", "question_id" => 2]);
		$answer->create(["answer" => "Picture", "question_id" => 2]);
		$answer->create(["answer" => "Script", "question_id" => 2]);
		
		$answer->create(["answer" => "Higher difficulties", "question_id" => 3]);
		$answer->create(["answer" => "Higher rank", "question_id" => 3]);
		$answer->create(["answer" => "More English knowledge", "question_id" => 3]);
		$answer->create(["answer" => "All of the above", "question_id" => 3]);
		
		$answer->create(["answer" => "Through highlighting and provided definitions", "question_id" => 4]);
		$answer->create(["answer" => "With your own dictionary", "question_id" => 4]);
		$answer->create(["answer" => "Search the definition on Google", "question_id" => 4]);
		$answer->create(["answer" => "It is impossible to learn new words", "question_id" => 4]);
		
		$answer->create(["answer" => "Account", "question_id" => 5]);
		$answer->create(["answer" => "Friends", "question_id" => 5]);
		$answer->create(["answer" => "Nothing", "question_id" => 5]);
		$answer->create(["answer" => "Being a lurker", "question_id" => 5]);
	}
}
