<?php

use LangLeap\Questions\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Videos\Commercial;
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
	}
	
	private function createQuestions()
	{
		$question = App::make('LangLeap\Questions\Question');
		//TODO
		/*$q1 = $question->create(["question" => "What does Language Leap teach?", "answer_id" => 0]);
		$q2 = $question->create(["question" => "What do you see beside the video?", "answer_id" => 0]);
		$q3 = $question->create(["question" => "What can you gain by spending more time on Language Leap?", "answer_id" => 0]);
		$q4 = $question->create(["question" => "How do you learn new words?", "answer_id" => 0]);
		$q5 = $question->create(["question" => "What do you need to use Language Leap?", "answer_id" => 0]);
		
		$language = Language::first();
		$video = Commercial::first()->videos()->create([
			'path' => '/path/to/tutorial/video.mkv',
			'language_id' => $language->id
		]);

		$answer = App::make('LangLeap\Quizzes\Answer');
		$answer->create(["answer" => "French", 'question_id' => $q1->id]);
		$answer1 = $answer->create(["answer" => "English", 'question_id' => $q1->id]);
		$answer->create(["answer" => "Spanish", 'question_id' => $q1->id]);
		$answer->create(["answer" => "Games", 'question_id' => $q1->id]);
		
		$answer->create(["answer" => "Another video", 'question_id' => $q2->id]);
		$answer->create(["answer" => "Nothing", 'question_id' => $q2->id]);
		$answer->create(["answer" => "Picture", 'question_id' => $q2->id]);
		$answer2 = $answer->create(["answer" => "Script", 'question_id' => $q2->id]);
		
		$answer->create(["answer" => "Higher difficulties", 'question_id' => $q3->id]);
		$answer->create(["answer" => "Higher rank", 'question_id' => $q3->id]);
		$answer->create(["answer" => "More English knowledge", 'question_id' => $q3->id]);
		$answer3 = $answer->create(["answer" => "All of the above", 'question_id' => $q3->id]);
		
		$answer4 = $answer->create(["answer" => "Through highlighting and provided definitions", 'question_id' => $q4->id]);
		$answer->create(["answer" => "With your own dictionary", 'question_id' => $q4->id]);
		$answer->create(["answer" => "Search the definition on Google", 'question_id' => $q4->id]);
		$answer->create(["answer" => "It is impossible to learn new words", 'question_id' => $q4->id]);
		
		$answer5 = $answer->create(["answer" => "Account", 'question_id' => $q5->id]);
		$answer->create(["answer" => "Friends", 'question_id' => $q5->id]);
		$answer->create(["answer" => "Nothing", 'question_id' => $q5->id]);
		$answer->create(["answer" => "Being a lurker", 'question_id' => $q5->id]);
		
		$q1->answer_id = $answer1->id;
		$q2->answer_id = $answer2->id;
		$q3->answer_id = $answer3->id;
		$q4->answer_id = $answer4->id;
		$q5->answer_id = $answer5->id;
		
		$q1->save();
		$q2->save();
		$q3->save();
		$q4->save();
		$q5->save();
		
		VideoQuestion::create([
			'video_id' => $video->id,
			'question_id' => $q1->id,
			'is_custom' => true
		]);
		
		VideoQuestion::create([
			'video_id' => $video->id,
			'question_id' => $q2->id,
			'is_custom' => true
		]);
		
		VideoQuestion::create([
			'video_id' => $video->id,
			'question_id' => $q3->id,
			'is_custom' => true
		]);
		
		VideoQuestion::create([
			'video_id' => $video->id,
			'question_id' => $q4->id,
			'is_custom' => true
		]);
		
		VideoQuestion::create([
			'video_id' => $video->id,
			'question_id' => $q5->id,
			'is_custom' => true
		]);*/
	}
}
