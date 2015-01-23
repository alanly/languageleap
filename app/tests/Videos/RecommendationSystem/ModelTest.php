<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ModelTest extends TestCase {

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
		$a->shouldReceive('newInstance')->once()->andReturn($a);

		$m = new Model($a);

		$this->assertSame($a, $m->test);

		$a->shouldReceive('newInstance')->andReturn(null);

		$this->assertSame($a, $m->test);
		$this->assertNull($m->shouldReturnNull);
	}


	/**
	 * @expectedException RuntimeException
	 */
	public function testFailsWhenAttemptingToSetAttributeDirectly()
	{
		$a = $this->getAttributeMock();
		$a->shouldReceive('newInstance')->once()->andReturn($a);

		$m = new Model($a);

		$m->test = null;
	}
	
}
