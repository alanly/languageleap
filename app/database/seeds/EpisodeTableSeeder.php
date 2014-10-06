<?php

use LangLeap\Videos\Episode;
class EpisodeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('episodes')->delete();

	    Episode::create(array("season_id"=>1, "number"=>1,"name"=>'Howard learns to ride a bike',"description"=>'The main character learns how to make a bike move'));
	}
}
