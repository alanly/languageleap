<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationDrivers;

use LangLeap\Videos\RecommendationSystem\Classifiable;
use LangLeap\Videos\RecommendationSystem\Historable;

/**
 * Defines the interface for the classification driver which acts as an
 * intermediary abstraction between the engine and the user.
 * @author Alan Ly <hello@alan.ly>
 */
interface ClassificationDriver {

	/**
	 * Classifies the classifiable subject against the historable user's profile.
	 * @param  Historable   $historable   The historable user that serves as the reference
	 * @param  Classifiable $classifiable The media subject that is classifiable
	 * @return float                      The rating of the classifiable subject
	 */
	public function classify(Historable $historable, Classifiable $classifiable);
	
}
