<?php

use LangLeap\Videos\Video;
use LangLeap\Videos\Episode;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Show;
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
			$commercial->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id, 'timestamps_json' => '[{"from":"1"},{"to":"2"}]']);
		}

		foreach (Episode::all() as $episode)
		{
			$episode->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id, 'timestamps_json' => '[{"from":"1"},{"to":"2"}]']);
		}

		foreach (Movie::all() as $movie)
		{
			$movie->videos()->create(['path' => '/videos/TestVideo.mp4', 'language_id'   => $lang->id, 'timestamps_json' => '[{"from":"1"},{"to":"2"}]']);

		}
	}
	
}
