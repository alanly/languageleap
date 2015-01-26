<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\RecommendationSystem\Facades\ModellerUtilities;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class UserModellerTest extends TestCase {

	protected function getModelableMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Modelable');
	}
	

	public function testStaticCreateMethodCreatesModellerInstance()
	{
		$modelable = $this->getModelableMock();

		$this->assertInstanceOf(
			'LangLeap\Videos\RecommendationSystem\UserModeller',
			UserModeller::create($modelable)
		);
	}


	public function testModelMethodReturnsModelInstance()
	{
		// Mock the modelable instance.
		$modelable = $this->getModelableMock();
		$modelable->shouldReceive('getViewingHistory')->once()->andReturn(new Collection);

		// Mock the ClassifierUtilities facade.		
		ModellerUtilities::shouldReceive('getClassifiableMediaFromHistory')->once();
		ModellerUtilities::shouldReceive('getClassificationAttributesFromMedia')->once()->andReturn(new Collection);
		ModellerUtilities::shouldReceive('populateModelFromAttributes')->once()->andReturn(new Collection);

		$modeller = new UserModeller($modelable);
		$model = $modeller->model();

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Model', $model);
	}

}
