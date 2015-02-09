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
		$season = Season::first();
		
		$season->episodes()->create(['number' => 1, 'name' => 'Test 1', 'description' => 'Test episode 1.', 'level_id' => $level->id]);
		$season->episodes()->create(['number' => 2, 'name' => 'Test 2', 'description' => 'Test episode 2.', 'level_id' => $level->id]);
	}
}
