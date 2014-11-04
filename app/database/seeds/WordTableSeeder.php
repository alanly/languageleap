<?php

class WordTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('words')->delete();

		$w = App::make('LangLeap\Words\Word');
		$w->create(array('word' => 'test', 'pronouciation'=>'test', 'definition' => 'test definition', 'full_definition'=>'test full definition'));
	}
}
