<?php

use LangLeap\Videos\Show;
class ShowTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('shows')->delete();

		Show::create(['name' => 'Test Show', 'description' => 'Test show description.', 'image_path' => '/img/misc/TestImage.jpg']);
		Show::create(['name' => 'Arrow', 'description' => 'Arrow description.']);
		Show::create(['name' => 'How I Met Your Mother', 'description' => 'How I met your mother description.', 'image_path' => '/img/misc/TestImage.jpg']);
		Show::create(['name' => 'The Strain', 'description' => 'The strain description.']);
		Show::create(['name' => 'The Flash', 'description' => 'The Flash description.', 'image_path' => '/img/misc/TestImage.jpg']);
	}
}
