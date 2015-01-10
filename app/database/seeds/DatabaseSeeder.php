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
		$this->call('LanguageTableSeeder');
		$this->call('TutorialQuizSeeder');
		$this->call('LevelTableSeeder');
		$this->call('MovieTableSeeder');
		$this->call('ShowTableSeeder');
		$this->call('CommercialTableSeeder');
		$this->call('SeasonTableSeeder');
		$this->call('EpisodeTableSeeder');
		$this->call('VideoTableSeeder');
		$this->call('ScriptTableSeeder');
		$this->call('DefinitionTableSeeder');
		$this->call('QuizTableSeeder');
		$this->call('QuestionTableSeeder');
		$this->call('UserTableSeeder');
	}
}