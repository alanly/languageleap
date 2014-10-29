<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		$this->call('CommercialTableSeeder');
		$this->call('DefinitionTableSeeder');
		$this->call('EpisodeTableSeeder');
		$this->call('MovieTableSeeder');
		$this->call('ScriptTableSeeder');
		$this->call('SeasonTableSeeder');
		$this->call('ShowTableSeeder');
		$this->call('WordTableSeeder');
		$this->call('VideoTableSeeder');
	}

}
