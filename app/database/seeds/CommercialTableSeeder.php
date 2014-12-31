<?php

use LangLeap\Levels\Level;

class CommercialTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('commercials')->delete();

		$level = Level::first();

		$c = App::make('LangLeap\Videos\Commercial');
		$c = $c->create(['name' => 'Test Commercial', 'level_id' => $level->id]);
	}
}
