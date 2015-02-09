<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Defines the interface for a video that can be classified by the
 * recommendation system.
 * @author Alan Ly <hello@alan.ly>
 */
interface Classifiable {

	/**
	 * Returns a dictionary of metadata attributes which this media should be
	 * classified by for the recommendation system.
	 * @return array
	 */
	public function getClassificationAttributes();
	
}
