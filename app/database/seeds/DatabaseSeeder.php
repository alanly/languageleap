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

		$this->call('MovieTableSeeder');
		$this->call('ShowTableSeeder');
		$this->call('CommercialTableSeeder');
		$this->call('SeasonTableSeeder');
		$this->call('EpisodeTableSeeder');
		$this->call('WordTableSeeder');
		$this->call('VideoTableSeeder');
		$this->call('ScriptTableSeeder');
	}

}