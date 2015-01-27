<?php namespace LangLeap\Videos\RecommendationSystem\Modellers;

use App;
use LangLeap\TestCase;
use LangLeap\Core\Collection;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class MediaModellerTest extends TestCase {

	public function tearDown()
	{
		parent::tearDown();
		m::close();
	}

	protected function getClassifiableMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
	}


	public function testStaticCreateMethodReturnsTheModellerInstance()
	{
		$classifiable = $this->getClassifiableMock();

		$this->assertInstanceOf(
			'LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller',
			MediaModeller::create($classifiable)
		);
	}


	public function testModelMethodReturnsAModelInstance()
	{
		$classifiable = $this->getClassifiableMock();
		$classifiable->shouldReceive('getClassificationAttributes')
		             ->andReturn(new Collection);

		$modeller = MediaModeller::create($classifiable);
		$model = $modeller->model();

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Model', $model);
	}

}
