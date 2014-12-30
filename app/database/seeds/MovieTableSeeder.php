<?php

use LangLeap\Videos\Movie;
class MovieTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('movies')->delete();

		Movie::create(array('name' => 'Brokeback Mountain', 'description'=>'The story of a forbidden and secretive relationship between two cowboys and their lives over the years.', 'level_id' => 1));
		Movie::create(array('name' => 'Twilight', 'description'=>'A teenage girl risks everything when she falls in love with a vampire.', 'level_id' => 2));
		Movie::create(array('name' => 'From Justin to Kelly', 'description'=>'A waitress from Texas and a college student from Pennsylvania meet during spring break in Fort Lauderdale, Florida and come together through their shared love of singing.', 'level_id' => 3));
	}
}
