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

		foreach (Show::all() as $show)
		{
			for ($i = 1; $i < 4; $i++)
			{
				$show->seasons()->create(['number' => $i]);
			}
		}
	}
}
