<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ScoreGeneratorTest extends TestCase {

	private function getDriverMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\ClassificationDrivers\ClassificationDriver');
	}


	private function getVideoMock()
	{
		return m::mock('LangLeap\Videos\Video');
	}


	private function getHistorableMock()
	{
		return m::mock('LangLeap\Videos\RecommendationSystem\Historable');
	}


	private function getCollectionInstance()
	{
		return new Collection;
	}


	public function testScoreReturnsAnAppropriateNumberOfVideosWithIndependantMediaInstances()
	{
		// Mock our video instance.
		$video = $this->getVideoMock();

		// Create our video collection and push in three copies of our video mock.
		$videos = $this->getCollectionInstance();
		$videos->push($video);
		$videos->push($video);
		$videos->push($video);

		// Mock our media instance.
		$media = m::mock('LangLeap\Videos\Media, LangLeap\Videos\RecommendationSystem\Classifiable');
		$media->shouldReceive('getHash')->times(3)->andReturn('foo', 'bar', 'foobar');

		// Define our video mock expectations.
		$video->shouldReceive('with')->once()->andReturn($video);
		$video->shouldReceive('get')->once()->andReturn($videos);
		$video->shouldReceive('getAttribute')->times(3)->with('viewable')->andReturn($media);
		
		// Define our classification driver mock.
		$driver = $this->getDriverMock();
		$driver->shouldReceive('classify')->times(3)->andReturn(1);
		
		$user = $this->getHistorableMock();

		$generator = new ScoreGenerator($driver, $video);

		$scored = $generator->score($user);

		$this->assertCount(3, $scored);
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $scored);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Recommendation', $scored->first());
		$this->assertSame($media, $scored->first()->getMedia());
		$this->assertSame(1, $scored->first()->getScore());
	}


	public function testScoreReturnsAnAppropriateNumberOfVideosWhenMultipleVideosShareMediaInstances()
	{
		// Mock our video instance.
		$video = $this->getVideoMock();

		// Create our video collection and push in three copies of our video mock.
		$videos = $this->getCollectionInstance();
		$videos->push($video);
		$videos->push($video);
		$videos->push($video);

		// Mock our media instance.
		$media = m::mock('LangLeap\Videos\Media, LangLeap\Videos\RecommendationSystem\Classifiable');
		$media->shouldReceive('getHash')->times(3)->andReturn('foo', 'bar', 'foo');

		// Define our video mock expectations.
		$video->shouldReceive('with')->once()->andReturn($video);
		$video->shouldReceive('get')->once()->andReturn($videos);
		$video->shouldReceive('getAttribute')->times(3)->with('viewable')->andReturn($media);
		
		// Define our classification driver mock.
		$driver = $this->getDriverMock();
		$driver->shouldReceive('classify')->times(2)->andReturn(1);
		
		$user = $this->getHistorableMock();

		$generator = new ScoreGenerator($driver, $video);

		$scored = $generator->score($user);

		$this->assertCount(2, $scored);
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $scored);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Recommendation', $scored->first());
		$this->assertSame($media, $scored->first()->getMedia());
		$this->assertSame(1, $scored->first()->getScore());
	}
	
}
