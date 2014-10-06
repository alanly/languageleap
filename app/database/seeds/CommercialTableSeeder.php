<?php

use LangLeap\Videos\Commercial;

class CommercialTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('commercials')->delete();
		Commercial::create(array('name' => 'TestCommercial', 'description'=>'This is a test commercial'));
	}
}
