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

		$show = Show::create([
			'name' => 'Test Show', 'description' => 'Test show description.'
		]);

		$season = $show->seasons()->create([
			'number' => 1, 'description' => 'Test season.'
		]);

		$episode = $season->episodes()->create([
			'number' => 1, 'name' => 'Test Episode', 'description' => 'Test episode description.'
		]);
	}
}
