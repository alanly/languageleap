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

		$w->create(array(
			'word' => 'hello',
			'definition' => 'a greeting.',
			'full_definition' => 'used as a greeting or to begin a telephone conversation.',
			'pronunciation' => 'hel·lo'
		));

		$w->create(array(
			'word' => 'definition',
			'definition' => 'a definition.',
			'full_definition' => 'a description a word',
			'pronunciation' => 'de-fi-ni-tion'
		));
		
		$w->create(array(
			'word' => 'random',
			'definition' => 'odd, unusual, or unexpected',
			'full_definition' => 'made, done, happening, or chosen without method or conscious decision.',
			'pronunciation' => 'randəm'
		));
		
		$w->create(array(
			'word' => 'phone',
			'definition' => 'a telephone.',
			'full_definition' => 'a system that converts acoustic vibrations to electrical signals in order to transmit sound, typically voices, over a distance using wire or radio.',
			'pronunciation' => 'fōn'
		));
	}

}