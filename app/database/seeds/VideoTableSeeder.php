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
		// Seed a video for an episode
		DB::table('videos')->delete();
		$episode_id = Episode::all()->first()->id;
		Video::create(array('viewable_id' => $episode_id, 'viewable_type' => 'LangLeap\Videos\Episode', 'path' => '1234'));

		// Seed a video for a movie
		$movie_id = Movie::all()->first()->id;
		Video::create(array('viewable_id' => $movie_id, 'viewable_type' => 'LangLeap\Videos\Movie', 'path' => '5678'));

		// Seed a video for a commercial
		$commercial_id = Commercial::all()->first()->id;
		Video::create(array('viewable_id' => $commercial_id, 'viewable_type' => 'LangLeap\Videos\Commercial', 'path' => '9101'));
	}
}