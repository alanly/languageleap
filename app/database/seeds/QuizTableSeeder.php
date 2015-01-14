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
		
		$q = App::make('LangLeap\Quizzes\Quiz');
		$q->create([
			'user_id' => $user_id
		]);
	}
}
