<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\TestCase;
use Mockery as m;

class UtilitiesTest extends TestCase {

	protected function getCollectionMock()
	{
		// Collection's and Traversable's are kind of hairy to mock, so we'll
		// just instantiate a Collection.
		return App::make('LangLeap\Core\Collection');
	}

	public function testGetClassifiableMediaFromHistoryReturnsACollection()
	{
		$u = new Utilities;
		$c = $this->getCollectionMock();

		$this->assertInstanceOf(
			'LangLeap\Core\Collection',
			$u->getClassifiableMediaFromHistory($c)
		);
	}
	
}
