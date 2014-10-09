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

	    Show::create(array('name' => 'The big bang thoery', 'description'=>'This is a show about nerds'));
	}
}
