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
		Movie::create(array('name' => 'Brokeback Mountain', 'description'=>'The story of a forbidden and secretive relationship between two cowboys and their lives over the years.'));
	}
}