<?php

use LangLeap\Videos\Movie;
use LangLeap\Levels\Level;

class MovieTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('movies')->delete();
		$level = Level::first();

		Movie::create(array('name' => 'Brokeback Mountain', 'description'=>'The story of a forbidden and secretive relationship between two cowboys and their lives over the years.', 'level_id' => $level->id, 'image_path' => '/img/misc/TestImage.jpg', 'is_published' => 1));
		Movie::create(array('name' => 'Twilight', 'description'=>'A teenage girl risks everything when she falls in love with a vampire.', 'level_id' => $level->id, 'image_path' => '/img/misc/TestImage.jpg', 'is_published' => 1));
		Movie::create(array('name' => 'From Justin to Kelly', 'description'=>'A waitress from Texas and a college student from Pennsylvania meet during spring break in Fort Lauderdale, Florida and come together through their shared love of singing.', 'level_id' => $level->id, 'image_path' => '/img/misc/TestImage.jpg', 'is_published' => 1));
	}
}
