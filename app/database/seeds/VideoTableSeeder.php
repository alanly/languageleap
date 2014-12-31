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
		
		Commercial::first()->videos()->create(['path' => '/path/to/somewhere/1.mkv', 'language_id'   => $lang->id]);
		Movie::first()->videos()->create(['path' => '/path/to/somewhere/2.mkv', 'language_id'   => $lang->id]);
		Episode::first()->videos()->create(['path' => '/path/to/somewhere/3.mkv', 'language_id'   => $lang->id]);
	}
}
