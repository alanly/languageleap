<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Show;

class ApiShowTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testShowApi()
	{
		$response = $this->action('GET', 'ApiShowController@index');
	    $this->assertResponseOk();
        $this->assertJson($response->getContent());
	}
	

}
