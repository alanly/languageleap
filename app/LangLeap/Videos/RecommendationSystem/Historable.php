<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Defines the interface for a user that can maintain a history of the videos
 * that it has viewed.
 * @author Alan Ly <hello@alan.ly>
 */
interface Historable {

	/**
	 * Retrieves a collection of the user's viewing history.
	 * @return Traversable|array
	 */
	public function getViewingHistory();
	
}
