<?php namespace LangLeap\Videos\RecommendationSystem\Modellers;

use App;
use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\RecommendationSystem\Facades\ModellerUtilities;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class UserModellerTest extends TestCase {

	protected function getHistorableMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Historable');
	}
	

	public function testStaticCreateMethodCreatesModellerInstance()
	{
		$historable = $this->getHistorableMock();

		$this->assertInstanceOf(
			'LangLeap\Videos\RecommendationSystem\Modellers\UserModeller',
			UserModeller::create($historable)
		);
	}


	public function testModelMethodReturnsModelInstance()
	{
		// Mock the historable instance.
		$historable = $this->getHistorableMock();
		$historable->shouldReceive('getViewingHistory')->once()->andReturn(new Collection);

		// Mock the ClassifierUtilities facade.		
		ModellerUtilities::shouldReceive('getClassifiableMediaFromHistory')->once();
		ModellerUtilities::shouldReceive('getClassificationAttributesFromMedia')->once()->andReturn(new Collection);
		ModellerUtilities::shouldReceive('populateModelFromAttributes')->once()->andReturn(new Collection);

		$modeller = new UserModeller($historable);
		$model = $modeller->model();

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Model', $model);
	}

}
