<?php

use LangLeap\Videos\Video;
use LangLeap\Videos\Episode;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Commercial;

class VideoTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('videos')->delete();

		Commercial::first()->videos()->create(['path' => '/path/to/somewhere/1.mkv']);
		Movie::first()->videos()->create(['path' => '/path/to/somewhere/2.mkv']);
		Episode::first()->videos()->create(['path' => '/path/to/somewhere/3.mkv']);
	}
}
