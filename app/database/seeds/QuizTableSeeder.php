<?php

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

		$user_id = \LangLeap\Accounts\User::first()->id;
		$video_id = \LangLeap\Videos\Video::first()->id;
		
		$category = App::make('LangLeap\Quizzes\VideoQuiz');
		$category = $category->create(['video_id' => $video_id]);
		
		$q = App::make('LangLeap\Quizzes\Quiz');
		$q->create([
			'user_id' => $user_id,
			'category_type' => 'LangLeap\Quizzes\VideoQuiz',
			'category_id' => $category->id,
		]);
	}
}
