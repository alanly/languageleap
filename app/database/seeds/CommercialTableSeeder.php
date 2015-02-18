<?php

class CommercialTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('commercials')->delete();

		$c = App::make('LangLeap\Videos\Commercial');
		$c = $c->create(['name' => 'Test Commercial', 'image_path' => '/img/misc/TestImage.jpg']);
		$c = $c->create(['name' => 'Doritos']);
		$c = $c->create(['name' => 'Gillete', 'image_path' => '/img/misc/TestImage.jpg']);
		$c = $c->create(['name' => 'Old Spice']);
		$c = $c->create(['name' => 'Test Commercial', 'image_path' => '/img/misc/TestImage.jpg']);
		$c = $c->create(['name' => 'Statefarm']);
		$c = $c->create(['name' => 'Nike', 'image_path' => '/img/misc/TestImage.jpg']);
	}
}
