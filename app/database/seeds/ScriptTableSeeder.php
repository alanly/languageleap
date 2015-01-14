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

		$scriptText = '<span data-type="actor" data-timestamp="0:00">Mike</span> This is a <span data-type="word" data-id="1">hello</span> script.' .
		'<span data-type="actor" data-timestamp="0:10">Jim</span> Here is another test <span data-type="word" data-id="2">definition</span>.';

		$videos = Video::all();

		foreach ($videos as $video)
		{
			$path = explode('\\', $video->viewable_type);
			$type = array_pop($path);

			Script::create(array('text' => $scriptText, 'video_id' => $video->id));
		}
	}

}
