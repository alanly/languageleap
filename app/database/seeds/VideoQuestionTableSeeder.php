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
		DB::table('videoquestions')->delete();
		$videoquestion = App::make('LangLeap\Quizzes\VideoQuestion');
		
		$quiz = Quiz::first();
		$video_id = Video::first()->id;
		
		$vq1 = $videoquestion->create(["question_id" => 1, "video_id" => $video_id, "is_custom" => false])->id;
		$vq2 = $videoquestion->create(["question_id" => 2, "video_id" => $video_id, "is_custom" => false])->id;
		$vq3 = $videoquestion->create(["question_id" => 3, "video_id" => $video_id, "is_custom" => false])->id;
		
		$quiz->videoquestions()->attach([$vq1, $vq2, $vq3]);
	}
}
