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
				$published = ($i % 2 == 0) ? 1 : 0;
				$show->seasons()->create(['number' => $i, 'is_published' => $published]);
			}
		}
	}
}
