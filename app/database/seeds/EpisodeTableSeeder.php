<?php

use LangLeap\Videos\Episode;
use LangLeap\Videos\Season;
class EpisodeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('episodes')->delete();

		foreach (Season::all() as $season)
		{
			for ($i = 1; $i < 4; $i++)
			{
				$season->episodes()->create(['number' => $i, 'name' => "Test $i", 'description' => "Test episode $i."]);
			}
		}
	}
}
