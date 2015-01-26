<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use Mocker as m;

class AttributeTest extends TestCase {

	protected function getAttributeInstance($name = 'test')
	{
		return new Attribute($name);
	}

	public function testAddingNewResident()
	{
		$a = $this->getAttributeInstance();

		$this->assertSame(1, $a->add('resident'));
	}


	public function testAddingToExistingResident()
	{
		$a = $this->getAttributeInstance();
		$a->add('resident');

		$this->assertSame(2, $a->add('resident'));
	}


	public function testCountingNonexistingResident()
	{
		$a = $this->getAttributeInstance();
		$this->assertSame(0, $a->count('test'));
	}


	public function testCountingExistingResident()
	{
		$a = $this->getAttributeInstance();
		$a->add('resident');
		$this->assertSame(1, $a->count('resident'));

		$a->add('resident');
		$this->assertSame(2, $a->count('resident'));
	}


	public function testNewInstanceCreatesANewInstance()
	{
		$a = $this->getAttributeInstance();
		$i = $a->newInstance('test');

		$this->assertNotSame($a, $i);
		$this->assertNotNull($i);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Attribute', $i);
	}


	public function testAttributeNameSetterAndGetter()
	{
		$a = $this->getAttributeInstance(null);

		$this->assertNull($a->getName());

		$a->setName('foobar');
		$this->assertSame('foobar', $a->getName());
	}


	public function testSize()
	{
		$a = $this->getAttributeInstance();

		$this->assertSame(0, $a->size());

		$a->add('foo');
		$a->add('foo');

		$this->assertSame(1, $a->size());

		$a->add('bar');

		$this->assertSame(2, $a->size());
	}
	
}