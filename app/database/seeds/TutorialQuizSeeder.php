<?php

use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Core\Language;

class TutorialQuizSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->createQuestions();
		$this->createAnswers();
	}
	
	private function createQuestions()
	{
		$question = App::make('LangLeap\Quizzes\Question');
		
		$q1 = $question->create(["question" => "What does Language Leap teach?", "answer_id" => 2]);
		$q2 = $question->create(["question" => "What do you see beside the video?", "answer_id" => 8]);
		$q3 = $question->create(["question" => "What can you gain by spending more time on Language Leap?", "answer_id" => 12]);
		$q4 = $question->create(["question" => "How do you learn new words?", "answer_id" => 13]);
		$q5 = $question->create(["question" => "What do you need to use Language Leap?", "answer_id" => 17]);
		
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$c = $this->createTutorialCommercial();
		$video = $c->videos()->first();
		
		/*$vq1 = $videoquestion->create(["question_id" => 1, "video_id" => $video->id, "is_custom" => true])->id;
		$vq2 = $videoquestion->create(["question_id" => 2, "video_id" => $video->id, "is_custom" => true])->id;
		$vq3 = $videoquestion->create(["question_id" => 3, "video_id" => $video->id, "is_custom" => true])->id;
		$vq4 = $videoquestion->create(["question_id" => 4, "video_id" => $video->id, "is_custom" => true])->id;
		$vq5 = $videoquestion->create(["question_id" => 5, "video_id" => $video->id, "is_custom" => true])->id;
		
		$quiz->videoQuestions()->attach([$vq1, $vq2, $vq3, $vq4, $vq5]);*/
	}
	
	private function createAnswers()
	{
		$answer = App::make('LangLeap\Quizzes\Answer');
		$answer->create(["answer" => "French", "question_id" => 1]);
		$answer->create(["answer" => "English", "question_id" => 1]);
		$answer->create(["answer" => "Spanish", "question_id" => 1]);
		$answer->create(["answer" => "Games", "question_id" => 1]);
		
		$answer->create(["answer" => "Another video", "question_id" => 2]);
		$answer->create(["answer" => "Nothing", "question_id" => 2]);
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

	private function createTutorialCommercial()
	{
		$c = App::make('LangLeap\Videos\Commercial');
		$c = $c->create(['name' => 'Tutorial Video']);

		$lang = Language::first();
		$c->videos()->create(['path' => '/path/to/somewhere/tutorial.mkv', 'language_id' => $lang->id]);

		return $c;
	}
}
