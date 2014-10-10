<?php
use LangLeap\Videos\Video;
class ScriptTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('scripts')->delete();

		$s = Video::first();
		$s->script()->create(['text' => 'Test script']);
	}
}
