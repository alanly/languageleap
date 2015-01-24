<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\TestCase;
use Mockery as m;

class UtilitiesTest extends TestCase {

	protected function getCollectionInstance($items = [])
	{
		// Collection's and Traversable's are kind of hairy to mock, so we'll
		// just instantiate a Collection.
		return App::make('LangLeap\Core\Collection', [$items]);
	}


	public function testGetClassifiableMediaFromHistoryReturnsACollection()
	{
		$u = new Utilities;
		$c = $this->getCollectionInstance();

		$this->assertInstanceOf(
			'LangLeap\Core\Collection',
			$u->getClassifiableMediaFromHistory($c)
		);
	}


	public function testGetClassificationAttributesFromMediaForSingleClassifiableInstance()
	{
		$c = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$c->shouldReceive('getClassificationAttributes')->once()->andReturn('foo');

		$u = new Utilities;
		$a = $u->getClassificationAttributesFromMedia($c);

		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
	}


	public function testGetClassificationAttributesFromMediaForCollectionOfClassifiableInstances()
	{
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$classifiable->shouldReceive('getClassificationAttributes')->times(3)->andReturn('foo');

		$collection = $this->getCollectionInstance([$classifiable, $classifiable, $classifiable]);

		$u = new Utilities;
		$a = $u->getClassificationAttributesFromMedia($collection);

		$this->assertCount(3, $a);
		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
		$this->assertSame('foo', $a[1]);
		$this->assertSame('foo', $a[2]);
	}


	public function testGetClassificationAttributesFromMediaForArrayOfClassifiableInstances()
	{
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$classifiable->shouldReceive('getClassificationAttributes')->times(3)->andReturn('foo');

		$array = [$classifiable, $classifiable, $classifiable];

		$u = new Utilities;
		$a = $u->getClassificationAttributesFromMedia($array);

		$this->assertCount(3, $a);
		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
		$this->assertSame('foo', $a[1]);
		$this->assertSame('foo', $a[2]);
	}
	
}
