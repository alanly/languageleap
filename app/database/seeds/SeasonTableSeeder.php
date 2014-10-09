<?php

use LangLeap\Videos\Season;
use LangLeap\Videos\Show;
class SeasonTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('seasons')->delete();
		$user_id = Show::all()->first()->id;
	    Season::create(array("number" => 1, "show_id"=>$user_id));
	    Season::create(array("number" => 2, "show_id"=>$user_id));
	    Season::create(array("number" => 3, "show_id"=>$user_id));
	}
}
