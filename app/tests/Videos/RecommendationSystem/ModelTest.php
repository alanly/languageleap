<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ModelTest extends TestCase {

	public function tearDown()
	{
		parent::tearDown();
		m::close();
	}
	

	protected function getAttributeMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Attribute');
	}


	public function testMagicGetMethodCreatesANewAttributeInstance()
	{
		// Mock the Attribute class; makes sure that one instance is created.
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->once()->andReturn($a);

		// Create a new Model instance with the mocked Attribute class injected.
		$m = new Model($a);

		$this->assertSame($a, $m->test);
	}


	public function testMagicMethodRetrievesExistingAttributeInstance()
	{
		// Create the attribute class
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->twice()->andReturn($a, null);

		$m = new Model($a);

		$this->assertSame($a, $m->test);

		$this->assertSame($a, $m->test);
		$this->assertNull($m->shouldReturnNull);
	}


	/**
	 * @expectedException RuntimeException
	 */
	public function testFailsWhenAttemptingToSetAttributeDirectly()
	{
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->never();

		$m = new Model($a);

		$m->test = null;
	}


	public function testCountableAndSize()
	{
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->once()->andReturn($a);

		$m = new Model($a);

		$this->assertInstanceOf('Countable', $m);

		$m->test;

		$this->assertSame(1, $m->size());
		$this->assertCount(1, $m);
	}


	public function testKeysFetchesAttributeNames()
	{
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->twice()->andReturn($a);

		$m = new Model($a);

		$m->test;
		$m->foobar;

		$k = $m->keys();

		$this->assertCount(2, $k);
		$this->assertContains('test', $k);
		$this->assertContains('foobar', $k);
	}


	public function testArrayable()
	{
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->twice()->andReturn($a);

		$m = new Model($a);

		$this->assertInstanceOf('Illuminate\Support\Contracts\ArrayableInterface', $m);

		$m->test;
		$m->foobar;

		$arr = $m->toArray();

		$this->assertCount(2, $arr);
		$this->assertSame($a, $arr['test']);
		$this->assertSame($a, $arr['foobar']);
	}
	
}
