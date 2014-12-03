<?php

use LangLeap\Quizzes\Question;
use LangLeap\Videos\Video;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Words\Definition;

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

		$videoquestion->create(["video_id" => 1, "question_id" => 1, "is_custom" => false]);
		$videoquestion->create(["video_id" => 1, "question_id" => 2, "is_custom" => false]);
		$videoquestion->create(["video_id" => 1, "question_id" => 2, "is_custom" => false]);
	}
}
