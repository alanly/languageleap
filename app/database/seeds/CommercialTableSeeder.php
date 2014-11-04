<?php

class CommercialTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('commercials')->delete();

		$c = App::make('LangLeap\Videos\Commercial');
		$c = $c->create(['name' => 'Test Commercial']);
	}
}
