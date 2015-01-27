<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationEngines;

use LangLeap\TestCase;
use LangLeap\Videos\RecommendationSystem\Model;
use Mockery as m;

class SimilarityClassificationEngineTest extends TestCase {

	protected function getModelMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Model');
	}


	protected function getAttributeMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Attribute');
	}


	protected function getEngineInstance()
	{
		return new SimilarityClassificationEngine;
	}


	public function testClassifyingTwoIdenticalModelsReturnsAnAppropriateResult()
	{
		$attribute = $this->getAttributeMock();
		$attribute->shouldReceive('getName')->andReturn('foobar');
		$attribute->shouldReceive('newInstance')->andReturn($attribute);
		$attribute->shouldReceive('weight')->andReturn(1);
		$attribute->shouldReceive('keys')->andReturn(['bar']);
		$attribute->shouldReceive('count')->with('bar')->andReturn(1);

		$model = new Model($attribute);
		$model = m::mock($model);
		$model->shouldReceive('toArray')->andReturn(['foobar' => $attribute]);

		$classifier = $this->getEngineInstance();

		$result = $classifier->classify($model, $model);

		$this->assertSame(1.0, round($result));
	}


	public function testClassifyingTwoDifferentModelsReturnsAnAppropriateResult()
	{
		// Ref. attribute
		$attr1 = $this->getAttributeMock();
		$attr1->shouldReceive('newInstance')->once()->andReturn($attr1);
		$attr1->shouldReceive('weight')->once()->andReturn(1);
		$attr1->shouldReceive('count')->once()->with('bar')->andReturn(0);

		// Classifying attribute
		$attr2 = $this->getAttributeMock();
		$attr2->shouldReceive('getName')->once()->andReturn('foobar');
		$attr2->shouldReceive('keys')->once()->andReturn(['bar']);

		$model1 = new Model($attr1);

		$model2 = new Model($attr2);
		$model2 = m::mock($model2);
		$model2->shouldReceive('toArray')->once()->andReturn(['foobar' => $attr2]);

		$classifier = $this->getEngineInstance();

		$result = $classifier->classify($model1, $model2);

		$this->assertNotSame(1.0, round($result));
	}


	public function testClassifyingTwoModelsWithAnEmptyReferenceModel()
	{
		// Ref. attribute
		$attr1 = $this->getAttributeMock();
		$attr1->shouldReceive('newInstance')->once()->andReturn($attr1);
		$attr1->shouldReceive('weight')->once()->andReturn(0);
		$attr1->shouldReceive('count')->once()->with('bar')->andReturn(0);

		// Classifying attribute
		$attr2 = $this->getAttributeMock();
		$attr2->shouldReceive('getName')->once()->andReturn('foobar');
		$attr2->shouldReceive('keys')->once()->andReturn(['bar']);

		$model1 = new Model($attr1);

		$model2 = new Model($attr2);
		$model2 = m::mock($model2);
		$model2->shouldReceive('toArray')->once()->andReturn(['foobar' => $attr2]);

		$classifier = $this->getEngineInstance();

		$result = $classifier->classify($model1, $model2);

		$this->assertSame(0, $result);
	}
	
}
