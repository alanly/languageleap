<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class RecommendatoreTest extends TestCase {

	private function getGeneratorMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\ScoreGenerator');
	}


	private function getRepositoryMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Repositories\RecommendationRepository');
	}


	private function getUserMock()
	{
		return m::mock('LangLeap\Accounts\User, LangLeap\Videos\RecommendationSystem\Historable');
	}


	public function testGenerateCallsDependenciesAppropriately()
	{
		$user = $this->getUserMock();

		$gen = $this->getGeneratorMock();
		$gen->shouldReceive('score')->with($user)->once()->andReturn(new Collection);

		$rep = $this->getRepositoryMock();
		$rep->shouldReceive('count')->once()->andReturn(1);
		$rep->shouldReceive('removeAll')->once()->andReturn(true);
		$rep->shouldReceive('multiAdd')->once()->andReturn(true);

		$rec = new Recommendatore($gen, $rep);

		$result = $rec->generate($user);
	}


	public function testFetchCallsDependenciesWithProperParameters()
	{
		$u = $this->getUserMock();

		$g = $this->getGeneratorMock();

		$r = $this->getRepositoryMock();
		$r->shouldReceive('getTop')->with($u, 3, true)->once()->andReturn('foo');

		$rec = new Recommendatore($g, $r);

		$res = $rec->fetch($u, 3, true);

		$this->assertSame('foo', $res);
	}

}
