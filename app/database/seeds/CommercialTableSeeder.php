<?php

use LangLeap\Levels\Level;

class CommercialTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('commercials')->delete();

		$level = Level::first();

		$c = App::make('LangLeap\Videos\Commercial');

		$c = $c->create(['name' => 'Test Commercial', 'image_path' => '/img/misc/TestImage.jpg', 'level_id' => $level->id]);
		$c = $c->create(['name' => 'Doritos', 'level_id' => $level->id]);
		$c = $c->create(['name' => 'Gillete', 'image_path' => '/img/misc/TestImage.jpg']);
		$c = $c->create(['name' => 'Old Spice', 'level_id' => $level->id]);
		$c = $c->create(['name' => 'Test Commercial', 'image_path' => '/img/misc/TestImage.jpg', 'level_id' => $level->id]);
		$c = $c->create(['name' => 'Statefarm', 'level_id' => $level->id]);
		$c = $c->create(['name' => 'Nike', 'image_path' => '/img/misc/TestImage.jpg', 'level_id' => $level->id]);
	}
}
