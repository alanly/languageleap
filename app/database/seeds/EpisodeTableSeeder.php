<?php

use LangLeap\Videos\Episode;
use LangLeap\Videos\Season;
class EpisodeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('episodes')->delete();
		$season_id = Season::all()->first()->id;
	    Episode::create(array("season_id"=>$season_id, "number"=>1,"name"=>"Howard learns to ride a bike","description"=>"The main character learns how to make a bike move"));
	    Episode::create(array("season_id"=>$season_id, "number"=>2,"name"=>"Leonerd and penny get married","description"=>"They get married OMG!"));
	}
}
