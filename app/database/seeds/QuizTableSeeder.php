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

		$q = App::make('LangLeap\Quizzes\Quiz');
		$q->create([]);
	}
}
