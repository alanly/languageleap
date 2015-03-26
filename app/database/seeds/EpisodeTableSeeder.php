<?php

use LangLeap\Videos\Episode;
use LangLeap\Videos\Season;
use LangLeap\Levels\Level;

class EpisodeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('episodes')->delete();

		$level = Level::first();
		$published = 1;
		foreach (Season::all() as $season)
		{
			for ($i = 1; $i < 5; $i++)
			{
				$season->episodes()->create(['number' => $i, 'name' => "Test $i", 'description' => "Test episode $i.", 'level_id' => $level->id, 'is_published' => $published]);
			}
		}

	}
}
