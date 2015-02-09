<?php

use LangLeap\Videos\Video;
use LangLeap\Words\Script;

class ScriptTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('scripts')->delete();

		$text = 'Replace this script text.';

		$videos = Video::all();

		foreach ($videos as $video)
		{
			$path = explode('\\', $video->viewable_type);
			$type = array_pop($path);

			Script::create(array('text' => $text, 'video_id' => $video->id));
		}
	}

}
