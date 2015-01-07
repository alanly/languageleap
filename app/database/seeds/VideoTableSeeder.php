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
		
		$movies = Movie::all();
		foreach ($movies as $movie)
		{
			$movie->videos()->create(['path' => '/path/to/somewhere/media.mkv', 'language_id'   => $lang->id]);
		}
				
		$commercials = Commercial::all();
		foreach ($commercials as $commercial)
		{
			$commercial->videos()->create(['path' => '/path/to/somewhere/media.mkv', 'language_id'   => $lang->id]);
		}
		
		$shows = Episode::all();
		foreach ($shows as $show)
		{
			$show->videos()->create(['path' => '/path/to/somewhere/media.mkv', 'language_id'   => $lang->id]);
		}
	}
	
}
