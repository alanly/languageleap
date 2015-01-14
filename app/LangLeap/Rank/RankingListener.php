<?php namespace LangLeap\Rank;

/**
 * @author Alan Ly <hello@alan.ly>
 */
interface RankingListener {

	/**
	 * Handle the appropriate response when the user is ranked. The given user
	 * parameter may either be the user instance that has been ranked (and
	 * updated) or it maybe the boolean result of the update operation.
	 * @param  mixed  $user
	 * @return mixed
	 */
	public function userRanked($user);
	
}
