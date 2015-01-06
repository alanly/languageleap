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
			'word' => 'Hello',
			'definition' => 'a greeting.',
			'full_definition' => 'used as a greeting or to begin a telephone conversation.',
			'pronunciation' => 'hel·lo',
			'synonym' => 'hi'
		));

		$w->create(array(
			'word' => 'Definition',
			'definition' => 'a definition.',
			'full_definition' => 'a description a word',
			'pronunciation' => 'de-fi-ni-tion',
			'synonym' => 'Meaning'
		));
		
		$w->create(array(
			'word' => 'Random',
			'definition' => 'odd, unusual, or unexpected',
			'full_definition' => 'made, done, happening, or chosen without method or conscious decision.',
			'pronunciation' => 'randəm',
			'synonym' => 'Arbitrary'
		));
		
		$w->create(array(
			'word' => 'Phone',
			'definition' => 'a telephone.',
			'full_definition' => 'a system that converts acoustic vibrations to electrical signals in order to transmit sound, typically voices, over a distance using wire or radio.',
			'pronunciation' => 'fōn',
			'synonym' => 'Communication'
		));
	}

}