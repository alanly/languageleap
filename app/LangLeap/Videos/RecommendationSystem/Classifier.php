<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Defines the interface for a media classifier.
 * @author Alan Ly <hello@alan.ly>
 */
interface Classifier {

	/**
	 * Determines the likelihood that a historable user will enjoy a classifiable
	 * media. The likelihood is represented as a float value, the higher of which
	 * means the greater the possibility that the user will like the video.
	 * @return float The likelihood that the user will enjoy the media.
	 */
	public function classify();

}
