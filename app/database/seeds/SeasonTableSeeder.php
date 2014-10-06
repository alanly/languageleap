<?php

use LangLeap\Videos\Season;
class SeasonTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('seasons')->delete();

	    Season::create(array("number" => 1, "show_id"=>1));
	}
}
