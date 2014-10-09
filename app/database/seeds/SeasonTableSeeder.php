<?php

use LangLeap\Videos\Season;
use LangLeap\Videos\Show;
class SeasonTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('seasons')->delete();

		$show = Show::first();
		$show->seasons()->create(['number' => 1]);
		$show->seasons()->create(['number' => 2]);
		$show->seasons()->create(['number' => 3]);
	}
}
