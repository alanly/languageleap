<?php
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

		$c = Commercial::first();
		$c->videos()->create(['path' => '/path/to/somewhere/1mkv']);
	}
}
