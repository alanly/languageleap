<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Defines the interface for a user that can be modelled by the recommendation
 * system.
 * @author Alan Ly <hello@alan.ly>
 */
interface Modelable {

	/**
	 * Retrieves a collection of the user's viewing history.
	 * @return Traversable|array
	 */
	public function getViewingHistory();
	
}
