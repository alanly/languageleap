<?php namespace LangLeap\Videos\RecommendationSystem\Repositories;

use App;
use Illuminate\Support\Facades\Redis as RedisClient;
use LangLeap\TestCase;
use LangLeap\Core\Collection;
use Mockery as m;

class RedisRecommendationRepositoryTest extends TestCase {

	private function getUserMock($id = 1000)
	{
		$m = m::mock('LangLeap\Accounts\User');
		$m->shouldReceive('getAttribute')->with('id')->once()->andReturn($id);

		return $m;
	}


	private function getRecommendationMock($media, $score = 0.4)
	{
		$m = m::mock('LangLeap\Videos\RecommendationSystem\Recommendation');
		$m->shouldReceive('getMedia')->once()->andReturn($media);

		if ($score !== null) $m->shouldReceive('getScore')->once()->andReturn($score);

		return $m;
	}


	private function getMediaMock($id = 1234)
	{
		$m = m::mock('LangLeap\Videos\Media');
		$m->shouldReceive('getAttribute')->with('id')->once()->andReturn($id);

		return $m;
	}


	private function getConnectionMock()
	{
		return m::mock('\Predis\ClientInterface');
	}


	public function testAddingNewRecommendationToStoreSendsCorrectValuesToTheConnection()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock the media instance
		$media = $this->getMediaMock();

		// Mock the recommendation instance
		$rec = $this->getRecommendationMock($media);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zadd')
		           ->with('user:1000.recommendations', 0.4, get_class($media).':1234')
		           ->once()
		           ->andReturn(1);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->add($user, $rec);

		$this->assertTrue($result);
	}


	public function testWhenAddingDuplicatesToTheStoreIsRejectedThatTheCorrectValueIsReturned()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock the media instance
		$media = $this->getMediaMock();

		// Mock the recommendation instance
		$rec = $this->getRecommendationMock($media);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zadd')
		           ->with('user:1000.recommendations', 0.4, get_class($media).':1234')
		           ->once()
		           ->andReturn(0);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->add($user, $rec);

		$this->assertFalse($result);
	}


	public function testRemovingExistingMemberCallsConnectionWithAppropriateParameters()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock the media instance
		$media = $this->getMediaMock();

		// Mock the recommendation instance
		$rec = $this->getRecommendationMock($media, null);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrem')
		           ->with('user:1000.recommendations', get_class($media).':1234')
		           ->once()
		           ->andReturn(1);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->remove($user, $rec);

		$this->assertTrue($result);
	}


	public function testRemovingNonExistentMemberReturnsTheCorrectValue()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock the media instance
		$media = $this->getMediaMock();

		// Mock the recommendation instance
		$rec = $this->getRecommendationMock($media, null);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrem')
		           ->once()
		           ->andReturn(0);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->remove($user, $rec);

		$this->assertFalse($result);
	}


	public function testRemoveAllFromTheStorePassesCorrectParametersToConnection()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zremrangebyrank')
		           ->with('user:1000.recommendations', 0, -1)
		           ->once()
		           ->andReturn(1);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->removeAll($user);

		$this->assertTrue($result);
	}


	public function testRemoveAllFromAnEmptyAndNonexistentStoreReturnsTheCorrectValue()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zremrangebyrank')
		           ->with('user:1000.recommendations', 0, -1)
		           ->once()
		           ->andReturn(0);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->removeAll($user);

		$this->assertFalse($result);
	}


	public function testCountAllCallsTheConnectionWithTheCorrectParameters()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zcard')
		           ->with('user:1000.recommendations')
		           ->once()
		           ->andReturn(1234);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->count($user);

		$this->assertSame(1234, $result);
	}


	public function testCountInScoreRangeCallsTheConnectionWithTheCorrectParameters()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zcount')
		           ->with('user:1000.recommendations', 0.75, 1)
		           ->once()
		           ->andReturn(1234);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->countBetweenScores($user, 0.75, 1);

		$this->assertSame(1234, $result);
	}


	public function testGetRangeInDescCallsWithCorrectParamsAndReturnsProperInstances()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock our media types
		$commercial = m::mock('LangLeap\Videos\Commercial');
		$commercial->shouldReceive('find')->with('7')->once()->andReturn($commercial);

		$show = m::mock('LangLeap\Videos\Show');
		$show->shouldReceive('find')->with('4')->once()->andReturn($commercial);

		App::instance('LangLeap\Videos\Commercial', $commercial);
		App::instance('LangLeap\Videos\Show', $show);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrange')
		           ->with('user:1000.recommendations', 3, 4, 'withscores')
		           ->once()
		           ->andReturn([
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           		['LangLeap\Videos\Show:4', '0.65']
		           	]);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->getRange($user, 3, 4, true);

		$this->assertInstanceOf('LangLeap\Core\Collection', $result);
		$this->assertCount(2, $result);

		$recommendation = $result->get(0);

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Recommendation', $recommendation);
		$this->assertEquals(0.7, $recommendation->getScore());
		$this->assertInstanceOf('LangLeap\Videos\Commercial', $recommendation->getMedia());
	}


	public function testGetRangeInAscCallsWithCorrectParamsAndReturnsProperInstances()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock our media types
		$commercial = m::mock('LangLeap\Videos\Commercial');
		$commercial->shouldReceive('find')->with('7')->once()->andReturn($commercial);

		$show = m::mock('LangLeap\Videos\Show');
		$show->shouldReceive('find')->with('4')->once()->andReturn($commercial);

		App::instance('LangLeap\Videos\Commercial', $commercial);
		App::instance('LangLeap\Videos\Show', $show);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrevrange')
		           ->with('user:1000.recommendations', 3, 4, 'withscores')
		           ->once()
		           ->andReturn([
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           		['LangLeap\Videos\Show:4', '0.65']
		           	]);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->getRange($user, 3, 4, false);

		$this->assertInstanceOf('LangLeap\Core\Collection', $result);
		$this->assertCount(2, $result);

		$recommendation = $result->get(0);

		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Recommendation', $recommendation);
		$this->assertEquals(0.7, $recommendation->getScore());
		$this->assertInstanceOf('LangLeap\Videos\Commercial', $recommendation->getMedia());
	}


	public function testGetRangeWillRemoveDeprecatedMember()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		$user->shouldReceive('getAttribute')->with('id')->once()->andReturn(1000);

		// Mock our media types
		$commercial = m::mock('LangLeap\Videos\Commercial');
		$commercial->shouldReceive('find')->with('7')->twice()->andReturn($commercial);

		App::instance('LangLeap\Videos\Commercial', $commercial);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrange')
		           ->with('user:1000.recommendations', 3, 4, 'withscores')
		           ->twice()
		           ->andReturn([
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           		['LangLeap\Videos\Show:4', '0.65']
		           	],
		           	[
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           	]);
    $connection->shouldReceive('zrem')
               ->with('user:1000.recommendations', 'LangLeap\Videos\Show:4')
               ->once()
               ->andReturn(1);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->getRange($user, 3, 4, true);

		$this->assertInstanceOf('LangLeap\Core\Collection', $result);
		$this->assertCount(1, $result);
	}


	public function testGetRangeWithSmallCollectionOfAllDeprecatedMembersWillReturnEmptyCollection()
	{
		// Mock the user instance
		$user = $this->getUserMock();
		$user->shouldReceive('getAttribute')->with('id')->twice()->andReturn(1000);

		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrange')
		           ->with('user:1000.recommendations', 3, 4, 'withscores')
		           ->times(3)
		           ->andReturn([
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           		['LangLeap\Videos\Show:4', '0.65']
		           	],
		           	[
		           		['LangLeap\Videos\Commercial:7', '0.7'],
		           	],
		           	[]);
    $connection->shouldReceive('zrem')
               ->twice()
               ->andReturn(1);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->getRange($user, 3, 4, true);

		$this->assertInstanceOf('LangLeap\Core\Collection', $result);
		$this->assertCount(0, $result);
	}


	public function testGetTopReturnsAppropriateCollection()
	{
		// Mock the user instance
		$user = $this->getUserMock();

		// Mock our media
		$commercial = m::mock('LangLeap\Videos\Commercial');
		$commercial->shouldReceive('find')->times(2)->andReturn($commercial);

		App::instance('LangLeap\Videos\Commercial', $commercial);
		
		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('zrange')
		           ->with('user:1000.recommendations', 0, 1, 'withscores')
		           ->once()
		           ->andReturn([
		           		['LangLeap\Videos\Commercial:7', '0.5'],
		           		['LangLeap\Videos\Commercial:4', '0.4'],
		           	]);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		// Add the recommendation
		$result = $repo->getTop($user, 2, true);

		$this->assertInstanceOf('LangLeap\Core\Collection', $result);
		$this->assertCount(2, $result);
	}


	public function testMultiAddCreatesARedisTransaction()
	{
		// Create the user mock
		$user = $this->getUserMock();

		// Mock a recommendation
		$m = $this->getMediaMock();
		$recom = $this->getRecommendationMock($m);

		// Mock the Redis client and connection
		$connection = $this->getConnectionMock();
		$connection->shouldReceive('pipeline')
		           ->once()
		           ->with(m::on(function($pipe)
		           	{
		           		$p = m::mock('\Predis\Pipeline\Pipeline');
		           		$p->shouldReceive('zadd')->once();
		           		$pipe($p);

		           		return true;
		           	}))
		           ->andReturn([1]);

		$client = RedisClient::shouldReceive('connection')->once()->andReturn($connection)->getMock();

		// Instantiate the repository with our mock client.
		$repo = new RedisRecommendationRepository($client);

		$result = $repo->multiAdd($user, new Collection([$recom]));

		$this->assertTrue($result);
	}

}
