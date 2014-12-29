<?php

class LanguageTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('languages')->delete();

		$l = App::make('LangLeap\Core\Language');
		$l = $l->create(['code' => 'en', 'description'=>'Engrish']);
	}
}
