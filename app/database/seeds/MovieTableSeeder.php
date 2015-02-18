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

		Movie::create(['name' => 'Brokeback Mountain', 'description'=>'The story of a forbidden and secretive relationship between two cowboys and their lives over the years.', 'image_path' => '/img/misc/TestImage.jpg']);
		Movie::create(['name' => 'Twilight', 'description'=>'A teenage girl risks everything when she falls in love with a vampire.', 'image_path' => '/img/misc/TestImage.jpg']);
		Movie::create(['name' => 'From Justin to Kelly', 'description'=>'A waitress from Texas and a college student from Pennsylvania meet during spring break in Fort Lauderdale, Florida and come together through their shared love of singing.']);
	}
}
