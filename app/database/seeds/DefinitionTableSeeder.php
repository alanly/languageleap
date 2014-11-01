<?php

use LangLeap\Words\Definition;
class DefinitionTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('definitions')->delete();

		$w = App::make('LangLeap\Words\Definition');
		$w->create(array('definition'=>'Hello', 'full_definition'=>'used as a greeting or to begin a telephone conversation.', 'pronunciation'=>'hel·lo'));
	}
}