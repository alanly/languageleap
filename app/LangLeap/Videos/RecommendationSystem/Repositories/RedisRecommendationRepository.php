<?php namespace LangLeap\Videos\RecommendationSystem\Repositories;

use App;
use Illuminate\Redis\Database as RedisClient;
use LangLeap\Accounts\User;
use Illuminate\Database\Eloquent\Collection;
use Langleap\Videos\Media;
use LangLeap\Videos\RecommendationSystem\Recommendation;
use LangLeap\Videos\RecommendationSystem\Exceptions\RecommendedModelNotFoundException;

/**
 * RedisRecommendationRepository allows access to the recommendation store.
 * @author Alan Ly <hello@alan.ly>
 */
class RedisRecommendationRepository implements RecommendationRepository {

	/**
	 * The Redis connection instance.
	 * @var \Predis\ClientInterface
	 */
	private $redis;


	/**
	 * Constructs a new repository client.
	 * @param RedisClient $redisClient The Redis client facade provided by Laravel
	 */
	public function __construct(RedisClient $redisClient)
	{
		// Using the client instance, we can get the default Redis connection.
		$this->initializeRedisConnection($redisClient);
	}


	/**
	 * Adds a recommendation to the store. Duplicate recommendations will not be
	 * added as the datastore is treated as a set.
	 * @param  User           $user           The owner of the store
	 * @param  Recommendation $recommendation The recommendation to be saved
	 * @return bool                           Success state of the transaction
	 */
	public function add(User $user, Recommendation $recommendation)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Get the recommendation values
		$score = $recommendation->getScore();
		$value = $this->generateMediaValue($recommendation->getMedia());

		// Add the values to the Redis store
		$result = $this->redis->zadd($key, $score, $value);

		return $result === 1;
	}


	/**
	 * Adds a collection of recommendations to the store. Duplicate recommendations
	 * will not be added as the datastore is treated as a set. The return value
	 * is true if and only if every item in the given collection has been added
	 * to the store.
	 * @param  User       $user            The owner of the store
	 * @param  Collection $recommendations The set of recommendations to be added
	 * @return bool                        Success state of the transaction
	 */
	public function multiAdd(User $user, Collection $recommendations)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Use a pipeline to run our inserts
		$result = $this->redis->pipeline(function($pipe) use ($key, $recommendations)
		{
			foreach ($recommendations as $r)
			{
				// Get the recommendation values
				$score = $r->getScore();
				$value = $this->generateMediaValue($r->getMedia());

				// Add the value to the store
				$pipe->zadd($key, $score, $value);
			}
		});

		// Check to see if the result size is the same as the collection size
		return count($result) === count($recommendations);
	}


	/**
	 * Removes a recommendation from the store.
	 * @param  User           $user           The owner of the store
	 * @param  Recommendation $recommendation The recommendation to be removed
	 * @return bool                           The success state of the transaction
	 */
	public function remove(User $user, Recommendation $recommendation)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Get the recommendation value
		$value = $this->generateMediaValue($recommendation->getMedia());

		// Remove the member from the store
		$result = $this->redis->zrem($key, $value);

		return $result === 1;
	}


	/**
	 * Removes all recommendations from the store.
	 * @param  User   $user The owner of the store
	 * @return bool         The success state of the transaction
	 */
	public function removeAll(User $user)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Remove all members from the store
		$result = $this->redis->zremrangebyrank($key, 0, -1);

		return $result === 1;
	}


	/**
	 * Get the total number of recommendations in the store.
	 * @param  User   $user The owner of the store
	 * @return int          The number of recommendations available
	 */
	public function count(User $user)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Remove all members from the store
		return $this->redis->zcard($key);
	}


	/**
	 * Get the number of recommendations, between the given range of scores, in
	 * the store.
	 * @param  User   $user The owner of the store
	 * @param  float  $min  The minimum score in the range
	 * @param  float  $max  The maximum score in the range
	 * @return int          The number of recommendations with a score between `$min` and `$max`
	 */
	public function countBetweenScores(User $user, $min, $max)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Remove all members from the store
		return $this->redis->zcount($key, $min, $max);
	}


	/**
	 * Get a collection of recommendations, between the given range of indexes,
	 * from the store. If `$desc` is true the result at index `$start` will contain
	 * the highest score in the range, and vice-versa.
	 * @param  User   $user  The owner of the store
	 * @param  int    $start The starting index in the range
	 * @param  int    $stop  The ending index in the range
	 * @param  bool   $desc  Get recommendations from the store in descending order by score
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getRange(User $user, $start, $stop, $desc = true)
	{
		// Get the key for the set
		$key = $this->generateSetKey($user);

		// Depending on whether or not we want everything in descending order,
		// we'll get the members either using `zrange` or `zrevrange`.
		if ($desc)
		{
			$results = $this->redis->zrange($key, $start, $stop, 'withscores');
		}
		else
		{
			$results = $this->redis->zrevrange($key, $start, $stop, 'withscores');
		}

		// Exit early if there are no results.
		if (count($results) === 0) return new Collection;

		try {
			// Convert the result array into a collection of recommendation instances.
			$recommendations = $this->getRecommendationsFromResults($results);
		} catch (RecommendedModelNotFoundException $e) {
			// If we encounter a recommendation for a model that no longer exists,
			// then let's just delete the recommendation and try the query again.
			// Note that this probably won't handle a corrupted data set very
			// gracefully, and in such a case, would depend entirely upon the runtime
			// timing-out or hitting its memory limit (due to the recursive call below).
			
			// Delete the entry
			$this->redis->zrem($key, $e->getModel().':'.$e->getKey());

			// Recursively call self again.
			return $this->getRange($user, $start, $stop, $desc);
		}

		return $recommendations;
	}


	/**
	 * Get a collection of the top recommendations, length `$take` from the store.
	 * If `$desc` is true the first result will be the highest scored, and vice-versa.
	 * @param  User   $user  The owner of the store
	 * @param  int    $take  The size of the range to take
	 * @param  bool   $desc  Get recommendations from the store in descending order by score
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getTop(User $user, $take, $desc)
	{
		return $this->getRange($user, 0, ($take - 1), $desc);
	}


	/**
	 * Initialize the Redis connection instance for the class using the given
	 * client instance for the (optionally) specified connection name.
	 * @param  RedisClient $client The client instance
	 * @param  string      $name   The name of the Redis instance
	 * @return \Predis\ClientInterface
	 */
	private function initializeRedisConnection(RedisClient $client, $name = '')
	{
		return $this->redis = $client->connection($name);
	}


	/**
	 * Generate the key for a sorted set, given a user instance.
	 * @param  User   $user The user that owns the set defined by the key
	 * @return string       The key of the set
	 */
	private function generateSetKey(User $user)
	{
		return "user:{$user->id}.recommendations";
	}


	/**
	 * Generate the string value to be stored for a given media instance. The
	 * value will be the concatenation of the class name and the primary ID, like
	 * so: `Commercial:73`.
	 * @param  Media  $media The media instance to be stored
	 * @return string        The string representation of the media instance
	 */
	private function generateMediaValue(Media $media)
	{
		return get_class($media).":{$media->id}";
	}


	/**
	 * Given a result array that's returned from the Redis connection, will parse
	 * and return a collection of recommendation instances.
	 * @param  array  $results The result given by the Redis connection
	 * @return Collection      A collection of recommendation instances
	 */
	private function getRecommendationsFromResults(array $results)
	{
		// Create a new collection to hold our instances.
		$recommendations = new Collection;

		// Loop through our two-dimensional array.
		foreach ($results as $r)
		{
			// Alias the score and value members.
			$score = $r[1];
			$value = $r[0];

			// Based on the value string, get the appropriate Media instance.
			$media = $this->getMediaFromValue($value);

			// Create a new recommendation instance with the media and score.
			$recommendation = new Recommendation($media, $score);

			// Push the instance onto our collection.
			$recommendations->push($recommendation);
		}

		return $recommendations;
	}


	/**
	 * Given the media value string, retrieved from the Redis store, will return
	 * the appropriate instance.
	 * @param  string $value The media value that represents the instance
	 * @return Media         A media instance
	 * @throws RecommendedModelNotFoundException If the media instance could not be found
	 */
	private function getMediaFromValue($value)
	{
		// Split the value string across the colon character.
		$detokened = explode(':', $value);

		// Alias the tokens.
		$className = $detokened[0];
		$primaryKey = $detokened[1];

		// Create the class instance
		$media = App::make($className);
		$media = $media->find($primaryKey);

		// If the media instance cannot be found, then throw an exception.
		if (! $media)
		{
			$e = new RecommendedModelNotFoundException;
			$e->setModel($className);
			$e->setKey($primaryKey);
			throw $e;
		}

		return $media;
	}
	
}
