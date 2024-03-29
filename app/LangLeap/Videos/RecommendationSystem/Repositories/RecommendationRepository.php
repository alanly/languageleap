<?php namespace LangLeap\Videos\RecommendationSystem\Repositories;

use LangLeap\Accounts\User;
use Illuminate\Database\Eloquent\Collection;
use LangLeap\Videos\RecommendationSystem\Recommendation;

/**
 * Defines the interface to access the recommendations store associated to a user.
 * @author Alan Ly <hello@alan.ly>
 */
interface RecommendationRepository {

	/**
	 * Adds a recommendation to the store. Duplicate recommendations will not be
	 * added as the datastore is treated as a set.
	 * @param  User           $user           The owner of the store
	 * @param  Recommendation $recommendation The recommendation to be saved
	 * @return bool                           Success state of the transaction
	 */
	public function add(User $user, Recommendation $recommendation);


	/**
	 * Adds a collection of recommendations to the store. Duplicate recommendations
	 * will not be added as the datastore is treated as a set. The return value
	 * is true if and only if every item in the given collection has been added
	 * to the store.
	 * @param  User       $user            The owner of the store
	 * @param  Collection $recommendations The set of recommendations to be added
	 * @return bool                        Success state of the transaction
	 */
	public function multiAdd(User $user, Collection $recommendations);


	/**
	 * Removes a recommendation from the store.
	 * @param  User           $user           The owner of the store
	 * @param  Recommendation $recommendation The recommendation to be removed
	 * @return bool                           The success state of the transaction
	 */
	public function remove(User $user, Recommendation $recommendation);


	/**
	 * Removes all recommendations from the store.
	 * @param  User   $user The owner of the store
	 * @return bool         The success state of the transaction
	 */
	public function removeAll(User $user);


	/**
	 * Get the total number of recommendations in the store.
	 * @param  User   $user The owner of the store
	 * @return int          The number of recommendations available
	 */
	public function count(User $user);


	/**
	 * Get the number of recommendations, between the given range of scores, in
	 * the store.
	 * @param  User   $user The owner of the store
	 * @param  float  $min  The minimum score in the range
	 * @param  float  $max  The maximum score in the range
	 * @return int          The number of recommendations with a score between `$min` and `$max`
	 */
	public function countBetweenScores(User $user, $min, $max);


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
	public function getRange(User $user, $start, $stop, $desc);


	/**
	 * Get a collection of the top recommendations, length `$take` from the store.
	 * If `$desc` is true the first result will be the highest scored, and vice-versa.
	 * @param  User   $user  The owner of the store
	 * @param  int    $take  The size of the range to take
	 * @param  bool   $desc  Get recommendations from the store in descending order by score
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getTop(User $user, $take, $desc);

}
