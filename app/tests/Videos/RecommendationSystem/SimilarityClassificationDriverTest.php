<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationDrivers;

use App;
use LangLeap\TestCase;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class SimilarityClassificationDriverTest extends TestCase {

	public function tearDown()
	{
		parent::tearDown();
		m::close();
	}
	

	public function testEngineGetsCalledWithAppropriateParameters()
	{
		// Mock the historable and classifiable instances.
		$historable = m::mock('LangLeap\Videos\RecommendationSystem\Historable');
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');

		// Model the necessary models
		$user = m::mock('LangLeap\Videos\RecommendationSystem\Model');
		$media = m::mock('LangLeap\Videos\RecommendationSystem\Model');

		// Mock the modellers for those instances.
		$userModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', [$historable]);
		$userModeller->shouldReceive('model')->once()->andReturn($user);

		$mediaModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', [$classifiable]);
		$mediaModeller->shouldReceive('model')->once()->andReturn($media);

		// Substitute the modeller instances into the autoloader.
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', $userModeller);
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', $mediaModeller);
		
		// Mock the engine
		$engine = m::mock('LangLeap\Videos\RecommendationSystem\ClassificationEngines\SimilarityClassificationEngine');
		$engine->shouldReceive('classify')->once()->with($user, $media)->andReturn('foobar');

		$driver = new SimilarityClassificationDriver($engine);

		$result = $driver->classify($historable, $classifiable);

		$this->assertSame('foobar', $result);
	}


	public function testConsecutiveClassificationsAgainstSingleHistorableModelUsesCachedModel()
	{
		// Mock the historable and classifiable instances.
		$historable = m::mock('LangLeap\Videos\RecommendationSystem\Historable');
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');

		// Model the necessary models
		$user = m::mock('LangLeap\Videos\RecommendationSystem\Model');
		$media = m::mock('LangLeap\Videos\RecommendationSystem\Model');

		// Mock the modellers for those instances.
		$userModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller');
		$userModeller->shouldReceive('model')->andReturn($user)->once();

		$mediaModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller');
		$mediaModeller->shouldReceive('model')->andReturn($media)->times(4);

		// Substitute the modeller instances into the autoloader.
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', $userModeller);
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', $mediaModeller);
		
		// Mock the engine
		$engine = m::mock('LangLeap\Videos\RecommendationSystem\ClassificationEngines\SimilarityClassificationEngine');
		$engine->shouldReceive('classify')->times(4)->with($user, $media)->andReturn('foobar');

		$driver = new SimilarityClassificationDriver($engine);

		// Run the classifier four times.
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
	}


	public function testConsecutiveClassificationsAgainstSingleHistorableModelWithCachedDisabled()
	{
		// Mock the historable and classifiable instances.
		$historable = m::mock('LangLeap\Videos\RecommendationSystem\Historable');
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');

		// Model the necessary models
		$user = m::mock('LangLeap\Videos\RecommendationSystem\Model');
		$media = m::mock('LangLeap\Videos\RecommendationSystem\Model');

		// Mock the modellers for those instances.
		$userModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller');
		$userModeller->shouldReceive('model')->andReturn($user)->times(4);

		$mediaModeller = m::mock('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller');
		$mediaModeller->shouldReceive('model')->andReturn($media)->times(4);

		// Substitute the modeller instances into the autoloader.
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', $userModeller);
		App::instance('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', $mediaModeller);
		
		// Mock the engine
		$engine = m::mock('LangLeap\Videos\RecommendationSystem\ClassificationEngines\SimilarityClassificationEngine');
		$engine->shouldReceive('classify')->times(4)->with($user, $media)->andReturn('foobar');

		$driver = new SimilarityClassificationDriver($engine);
		$driver->enableHistorableCaching(false);

		// Run the classifier four times.
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
		$driver->classify($historable, $classifiable);
	}

}
