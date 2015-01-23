<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use Mocker as m;

class AttributeTest extends TestCase {

	public function testAddingNewResident()
	{
		$a = new Attribute;

		$this->assertSame(1, $a->add('resident'));
	}


	public function testAddingToExistingResident()
	{
		$a = new Attribute;
		$a->add('resident');

		$this->assertSame(2, $a->add('resident'));
	}


	public function testCountingNonexistingResident()
	{
		$a = new Attribute;
		$this->assertSame(0, $a->count('test'));
	}


	public function testCountingExistingResident()
	{
		$a = new Attribute;
		$a->add('resident');
		$this->assertSame(1, $a->count('resident'));

		$a->add('resident');
		$this->assertSame(2, $a->count('resident'));
	}


	public function testNewInstanceCreatesANewInstance()
	{
		$a = new Attribute;
		$i = $a->newInstance();

		$this->assertNotSame($a, $i);
		$this->assertNotNull($i);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Attribute', $i);
	}
	
}
