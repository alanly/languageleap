<?php

use LangLeap\Videos\Video;
use LangLeap\Videos\Episode;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Commercial;
use LangLeap\Core\Language;

class VideoTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('videos')->delete();

		$lang = Language::first();

		foreach (Commercial::all() as $commercial)
		{
			$commercial->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id]);
		}

		foreach (Episode::all() as $episode)
		{
			$episode->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id]);
		}

		foreach (Movie::all() as $movie)
		{
			$movie->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id]);
		}
	}
}
