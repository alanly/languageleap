<?php

class LevelTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('levels')->delete();

		$unranked = App::make('LangLeap\Levels\Level');
		$unranked = $unranked->create(['code' => 'ur', 'description'=>'Unranked']);
		
		$beginner = App::make('LangLeap\Levels\Level');
		$beginner = $beginner->create(['code' => 'be', 'description'=>'Beginner']);

		$intermediate = App::make('LangLeap\Levels\Level');
		$intermediate = $intermediate->create(['code' => 'in', 'description'=>'Intermediate']);

		$advanced = App::make('LangLeap\Levels\Level');
		$advanced = $advanced->create(['code' => 'ad', 'description'=>'Advanced']);
	}
}
