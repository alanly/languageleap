<?php

use LangLeap\Quizzes\Quiz;
use LangLeap\Videos\Video;

class QuizTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('quizzes')->delete();

		$vid = Video::first();
		$q = App::make('LangLeap\Quizzes\Quiz');
		$q->create(["video_id" => $vid->id, "user_id" => 1]);
	}
}
