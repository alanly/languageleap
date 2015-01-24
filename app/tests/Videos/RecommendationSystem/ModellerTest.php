<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\RecommendationSystem\Facades\ClassifierUtilities;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ModellerTest extends TestCase {

	protected function getModelableMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Modelable');
	}
	

	public function testStaticCreateMethodCreatesModellerInstance()
	{
		$modelable = $this->getModelableMock();

		$this->assertInstanceOf(
			'LangLeap\Videos\RecommendationSystem\Modeller',
			Modeller::create($modelable)
		);
	}


	public function testModelMethodReturnsModelInstance()
	{
		// Mock the modelable instance.
		$modelable = $this->getModelableMock();
		$modelable->shouldReceive('getViewingHistory')->once()->andReturn(new Collection);

		// Mock the ClassifierUtilities facade.		
		ClassifierUtilities::shouldReceive('getClassifiableMediaFromHistory');

		$modeller = new Modeller($modelable);
		$model = $modeller->model();

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Model', $model);
	}

}
